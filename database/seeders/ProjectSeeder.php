<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use App\Models\ProjectCategory;
use App\Models\ProjectStatus;
use App\Models\ProjectTheme;
use App\Models\ProjectDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure storage link exists and create dummy file for upload
        if (!Storage::disk('public')->exists('project_documents')) {
            Storage::disk('public')->makeDirectory('project_documents');
        }
        $dummyFilePath = Storage::disk('public')->path('project_documents/dummy_proposal.pdf');
        if (!file_exists($dummyFilePath)) {
            // Create a simple dummy pdf file if it doesn't exist
            // For a real seeder, you might have a sample file in storage/app/seed_files
            file_put_contents($dummyFilePath, '%PDF-1.4\n%âãÏÓ\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/MediaBox[0 0 612 792]/Parent 2 0 R/Resources<<>>>>endobj\nxref\n0 4\n0000000000 65535 f\n0000000010 00000 n\n0000000062 00000 n\n0000000111 00000 n\ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n167\n%%EOF');
        }

        // Fetch Prerequisite Data
        $adminUser = User::whereHas('roles', fn ($query) => $query->where('name', 'admin'))->first();
        $participantUsers = User::whereHas('roles', fn ($query) => $query->where('name', 'participant'))->take(3)->get();
        $evaluatorUsers = User::whereHas('roles', fn ($query) => $query->where('name', 'evaluator'))->take(2)->get();

        $categories = ProjectCategory::all();
        $statuses = ProjectStatus::orderBy('sequence_order')->get(); // Get in order
        $themes = ProjectTheme::all();

        if (!$adminUser) {
            $this->command->error('Admin user not found. Please run AdminUserSeeder.');
            return;
        }
        if ($participantUsers->count() < 2) {
            $this->command->warn('Less than 2 participant users found. Project seeding might be limited.');
        }
        if ($evaluatorUsers->count() < 2) {
            $this->command->warn('Less than 2 evaluator users found. Project seeding might be limited.');
        }
        if ($categories->isEmpty() || $statuses->isEmpty() || $themes->isEmpty()) {
            $this->command->error('Project categories, statuses, or themes not found. Please run ProjectTaxonomySeeder.');
            return;
        }

        $initialStatus = $statuses->firstWhere('sequence_order', 1) ?? $statuses->first(); // e.g., 'Proposal Submitted'
        $inProgressStatus = $statuses->firstWhere('sequence_order', 4) ?? $statuses->first(); // e.g., 'In Progress'

        $projectsData = [
            [
                'title' => 'AI-Powered Academic Advisor Bot',
                'description' => 'A chatbot to assist students with course selection and academic planning using AI.',
                'created_by_user_index' => 0, // Index for $participantUsers
                'category_index' => 0, // Index for $categories (Software Development)
                'status_id' => $initialStatus->id,
                'themes_indices' => [0, 3], // AI, Data Science
                'participants_config' => [
                    ['user_index' => 0, 'is_director' => true],
                ],
                'evaluators_indices' => [0], // Index for $evaluatorUsers
                'document_type' => 'Project Proposal'
            ],
            [
                'title' => 'IoT-Based Smart Irrigation System',
                'description' => 'Developing a smart irrigation system using IoT sensors for efficient water management in agriculture.',
                'created_by_user_index' => 1, // Index for $participantUsers
                'category_index' => 2, // Index for $categories (Hardware Design)
                'status_id' => $inProgressStatus->id,
                'themes_indices' => [2, 4], // Mobile App (for control), IoT
                'participants_config' => [
                    ['user_index' => 1, 'is_director' => true],
                    ['user_index' => 2, 'is_director' => false], // Add a second participant
                ],
                'evaluators_indices' => [1],
                'document_type' => 'Initial Design Document'
            ],
        ];

        foreach ($projectsData as $data) {
            if (!isset($participantUsers[$data['created_by_user_index']])) {
                $this->command->warn('Skipping project due to missing creator participant: ' . $data['title']);
                continue;
            }
            $creator = $participantUsers[$data['created_by_user_index']];

            $project = Project::firstOrCreate(
                ['title' => $data['title']],
                [
                    'description' => $data['description'],
                    'project_category_id' => $categories[$data['category_index']]->id,
                    'project_status_id' => $data['status_id'],
                    'submission_date' => Carbon::now()->subDays(rand(5, 30)),
                    'created_by' => $creator->id, // Assigning project creator
                    'final_score' => null, // Changed from 'score'
                ]
            );

            // Attach Themes
            $projectThemes = $themes->collect()->only($data['themes_indices'])->pluck('id');
            $project->themes()->sync($projectThemes);

            // Attach Participants
            $participantsToSync = [];
            foreach ($data['participants_config'] as $pConfig) {
                if (isset($participantUsers[$pConfig['user_index']])) {
                    $participantsToSync[$participantUsers[$pConfig['user_index']]->id] = ['is_director' => $pConfig['is_director']];
                }
            }
            $project->participants()->syncWithoutDetaching($participantsToSync);

            // Attach Evaluators
            $evaluatorsToSync = [];
            foreach ($data['evaluators_indices'] as $evaluatorIndex) {
                if (isset($evaluatorUsers[$evaluatorIndex])) {
                    $evaluatorsToSync[$evaluatorUsers[$evaluatorIndex]->id] = [
                        'assigned_by' => $adminUser->id,
                        'assigned_date' => Carbon::now(),
                    ];
                }
            }
            $project->evaluators()->syncWithoutDetaching($evaluatorsToSync);

            // Add a Project Document
            // Note: The ProjectObserver should handle initial status history.
            $storedFilePath = Storage::disk('public')->putFile('project_documents', new File($dummyFilePath));
            ProjectDocument::create([
                'project_id' => $project->id,
                'document_type' => $data['document_type'],
                'file_path' => $storedFilePath,
                'uploaded_by' => $creator->id,
                'upload_date' => Carbon::now(),
            ]);
            $this->command->info("Seeded project: {$project->title}");
        }
        $this->command->info('ProjectSeeder completed.');
    }
}
