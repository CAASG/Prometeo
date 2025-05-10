<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;
use App\Models\ProjectTheme;
use App\Models\ProjectStatus;

class ProjectTaxonomySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Project Categories
        $categories = [
            ['name' => 'Software Development', 'description' => 'Projects related to software engineering and application development.'],
            ['name' => 'Research Thesis', 'description' => 'Academic research projects and theses.'],
            ['name' => 'Hardware Design', 'description' => 'Projects involving electronic hardware design and implementation.'],
            ['name' => 'Community Project', 'description' => 'Projects aimed at benefiting a specific community.'],
        ];

        foreach ($categories as $category) {
            ProjectCategory::firstOrCreate(['name' => $category['name']], $category);
        }
        $this->command->info('Seeded project categories.');

        // Project Themes
        $themes = [
            ['name' => 'Artificial Intelligence', 'description' => 'AI and Machine Learning applications.'],
            ['name' => 'Web Development', 'description' => 'Web technologies and frameworks.'],
            ['name' => 'Mobile Applications', 'description' => 'Development for mobile platforms.'],
            ['name' => 'Data Science', 'description' => 'Data analysis, visualization, and big data.'],
            ['name' => 'Internet of Things (IoT)', 'description' => 'Connected devices and IoT solutions.'],
            ['name' => 'Sustainability', 'description' => 'Projects focused on environmental or social sustainability.'],
        ];

        foreach ($themes as $theme) {
            ProjectTheme::firstOrCreate(['name' => $theme['name']], $theme);
        }
        $this->command->info('Seeded project themes.');

        // Project Statuses (with sequence_order)
        $statuses = [
            ['name' => 'Proposal Submitted', 'description' => 'Initial project proposal has been submitted.', 'sequence_order' => 1],
            ['name' => 'Under Review', 'description' => 'Project is currently being reviewed by evaluators.', 'sequence_order' => 2],
            ['name' => 'Approved', 'description' => 'Project has been approved to proceed.', 'sequence_order' => 3],
            ['name' => 'In Progress', 'description' => 'Project development or research is actively ongoing.', 'sequence_order' => 4],
            ['name' => 'Pending Revisions', 'description' => 'Project requires revisions based on feedback.', 'sequence_order' => 5],
            ['name' => 'Completed', 'description' => 'Project has been successfully completed.', 'sequence_order' => 6],
            ['name' => 'Rejected', 'description' => 'Project proposal has been rejected.', 'sequence_order' => 7],
            ['name' => 'Archived', 'description' => 'Project is archived and no longer active.', 'sequence_order' => 8],
        ];

        foreach ($statuses as $status) {
            ProjectStatus::firstOrCreate(['name' => $status['name']], $status);
        }
        $this->command->info('Seeded project statuses.');
    }
}
