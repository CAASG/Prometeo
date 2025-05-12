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
use App\Models\Evaluation;
use App\Models\EvaluationPhase;
use App\Models\RubricCriterion;
use App\Models\EvaluationScore;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Arr;

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

        // Fetch specific evaluators for consistent assignment
        $evaluatorTestUser = User::where('email', 'evaluator@prometeo.test')->first();
        $otherEvaluator = User::whereHas('roles', fn ($query) => $query->where('name', 'evaluator'))
                                ->where('email', '!=', 'evaluator@prometeo.test')
                                ->first();

        $targetEvaluators = [];
        if ($evaluatorTestUser) {
            $targetEvaluators[] = $evaluatorTestUser;
        }
        if ($otherEvaluator) {
            $targetEvaluators[] = $otherEvaluator;
        }

        $categories = ProjectCategory::all();
        $statuses = ProjectStatus::orderBy('sequence_order')->get();
        $themes = ProjectTheme::all();
        $evaluationPhases = EvaluationPhase::where('is_active', true)->with('criteria')->get();

        if (!$adminUser) {
            $this->command->error('Admin user not found. Please run AdminUserSeeder.');
            return;
        }
        if ($participantUsers->count() < 2) {
            $this->command->warn('Less than 2 participant users found. Project seeding might be limited.');
        }
        // Use count($targetEvaluators) for checks now
        if (count($targetEvaluators) < 1) {
            $this->command->warn('Target evaluator(s) not found. Evaluation seeding will be skipped or limited.');
        }
        if ($categories->isEmpty() || $statuses->isEmpty() || $themes->isEmpty()) {
            $this->command->error('Project categories, statuses, or themes not found. Please run ProjectTaxonomySeeder.');
            return;
        }
        if ($evaluationPhases->isEmpty()) {
            $this->command->warn('No active evaluation phases found. Evaluation seeding will be limited.');
        }

        $initialStatus = $statuses->firstWhere('sequence_order', 1) ?? $statuses->first();
        $inProgressStatus = $statuses->firstWhere('sequence_order', 4) ?? $statuses->first();

        $projectsData = [
            [
                'title' => 'AI-Powered Academic Advisor Bot',
                'description' => 'A chatbot to assist students with course selection and academic planning using AI.',
                'created_by_user_index' => 0,
                'category_index' => 0,
                'status_id' => $initialStatus->id,
                'themes_indices' => [0, 3],
                'participants_config' => [
                    ['user_index' => 0, 'is_director' => true],
                ],
                'evaluator_target_indices' => [0], // Index for $targetEvaluators (should be evaluator@prometeo.test)
                'document_type' => 'Project Proposal',
                'seed_evaluation' => true,
                'evaluation_completed' => true
            ],
            [
                'title' => 'IoT-Based Smart Irrigation System',
                'description' => 'Developing a smart irrigation system using IoT sensors for efficient water management in agriculture.',
                'created_by_user_index' => 1,
                'category_index' => 2,
                'status_id' => $inProgressStatus->id,
                'themes_indices' => [2, 4],
                'participants_config' => [
                    ['user_index' => 1, 'is_director' => true],
                    ['user_index' => 2, 'is_director' => false],
                ],
                // Assign to the second target evaluator if available, otherwise fallback or skip
                'evaluator_target_indices' => count($targetEvaluators) > 1 ? [1] : (count($targetEvaluators) > 0 ? [0] : []),
                'document_type' => 'Initial Design Document',
                'seed_evaluation' => false, 
            ],
            [
                'title' => 'Renewable Energy Storage Solutions',
                'description' => 'Research and development of innovative battery technologies for renewable energy storage.',
                'created_by_user_index' => 0,
                'category_index' => 1,
                'status_id' => $initialStatus->id,
                'themes_indices' => [1, 5],
                'participants_config' => [
                    ['user_index' => 0, 'is_director' => true],
                ],
                'evaluator_target_indices' => [0], // Index for $targetEvaluators (evaluator@prometeo.test)
                'document_type' => 'Project Proposal',
                'seed_evaluation' => true,
                'evaluation_completed' => false
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
                    'created_by' => $creator->id,
                    'final_score' => null,
                ]
            );

            $projectThemes = $themes->collect()->only($data['themes_indices'])->pluck('id');
            $project->themes()->sync($projectThemes);

            $participantsToSync = [];
            foreach ($data['participants_config'] as $pConfig) {
                if (isset($participantUsers[$pConfig['user_index']])) {
                    $participantsToSync[$participantUsers[$pConfig['user_index']]->id] = ['is_director' => $pConfig['is_director']];
                }
            }
            $project->participants()->syncWithoutDetaching($participantsToSync);

            $currentProjectEvaluators = [];
            // Use $targetEvaluators for assignment
            foreach ($data['evaluator_target_indices'] as $evaluatorTargetIndex) {
                if (isset($targetEvaluators[$evaluatorTargetIndex])) {
                    $evaluator = $targetEvaluators[$evaluatorTargetIndex];
                    $currentProjectEvaluators[] = $evaluator;
                    $project->evaluators()->syncWithoutDetaching([
                        $evaluator->id => [
                            'assigned_by' => $adminUser->id,
                            'assigned_date' => Carbon::now(),
                        ]
                    ]);
                }
            }
            
            $storedFilePath = Storage::disk('public')->putFile('project_documents', new File($dummyFilePath));
            ProjectDocument::create([
                'project_id' => $project->id,
                'document_type' => $data['document_type'],
                'file_path' => $storedFilePath,
                'uploaded_by' => $creator->id,
                'upload_date' => Carbon::now(),
            ]);

            if ($data['seed_evaluation'] && !empty($currentProjectEvaluators) && !$evaluationPhases->isEmpty()) {
                $assignedEvaluator = $currentProjectEvaluators[0];
                $evaluationPhaseForSeeding = $evaluationPhases->first();

                if ($evaluationPhaseForSeeding && $evaluationPhaseForSeeding->criteria->isNotEmpty()) {
                    $evaluation = Evaluation::create([
                        'project_id' => $project->id,
                        'evaluator_id' => $assignedEvaluator->id,
                        'evaluation_phase_id' => $evaluationPhaseForSeeding->id,
                        'comments' => $data['evaluation_completed'] ? 'This evaluation was auto-seeded as completed.' : 'This evaluation was auto-seeded as pending.',
                        'is_completed' => $data['evaluation_completed'],
                        'evaluation_date' => Carbon::now()->subDays(rand(1, 5)),
                    ]);

                    foreach ($evaluationPhaseForSeeding->criteria as $criterion) {
                        EvaluationScore::create([
                            'evaluation_id' => $evaluation->id,
                            'rubric_criteria_id' => $criterion->id,
                            'score' => $data['evaluation_completed'] ? rand( (int)($criterion->max_score * 0.6), (int)$criterion->max_score) : rand(0, (int)($criterion->max_score * 0.5) ),
                            'comments' => 'Auto-seeded score for criterion: ' . $criterion->name,
                        ]);
                    }
                    $evaluation->calculateTotalScore();
                    $this->command->info("Seeded evaluation for project: {$project->title} by {$assignedEvaluator->name}");
                }
            }
            $this->command->info("Seeded project: {$project->title}");
        }
        $this->command->info('ProjectSeeder completed.');
    }
}
