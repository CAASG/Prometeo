<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EvaluationPhase;
use App\Models\RubricCriterion;

class EvaluationSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Evaluation Phases
        $phasesData = [
            [
                'name' => 'Phase 1: Proposal Quality',
                'description' => 'Evaluation of the initial project proposal.',
                'sequence_order' => 1,
                'weight' => 30, // Example weight (percentage)
                'is_active' => true,
                'criteria' => [
                    ['name' => 'Clarity of Objectives', 'description' => 'Are the project objectives clear and well-defined?', 'max_score' => 20, 'is_active' => true],
                    ['name' => 'Methodology Soundness', 'description' => 'Is the proposed methodology appropriate and robust?', 'max_score' => 30, 'is_active' => true],
                    ['name' => 'Feasibility', 'description' => 'Is the project feasible within the given constraints (time, resources)?', 'max_score' => 25, 'is_active' => true],
                    ['name' => 'Innovation/Originality', 'description' => 'Does the project demonstrate innovation or originality?', 'max_score' => 25, 'is_active' => true],
                ]
            ],
            [
                'name' => 'Phase 2: Progress Review',
                'description' => 'Mid-term evaluation of project progress and execution.',
                'sequence_order' => 2,
                'weight' => 40,
                'is_active' => true,
                'criteria' => [
                    ['name' => 'Progress Towards Objectives', 'description' => 'Has significant progress been made towards achieving objectives?', 'max_score' => 30, 'is_active' => true],
                    ['name' => 'Problem Solving', 'description' => 'How effectively were challenges and obstacles addressed?', 'max_score' => 30, 'is_active' => true],
                    ['name' => 'Quality of Work', 'description' => 'Is the work produced of high quality?', 'max_score' => 20, 'is_active' => true],
                    ['name' => 'Adherence to Timeline', 'description' => 'Is the project on track with the proposed timeline?', 'max_score' => 20, 'is_active' => true],
                ]
            ],
            [
                'name' => 'Phase 3: Final Presentation & Deliverables',
                'description' => 'Evaluation of the final project presentation and deliverables.',
                'sequence_order' => 3,
                'weight' => 30,
                'is_active' => true,
                'criteria' => [
                    ['name' => 'Completeness of Deliverables', 'description' => 'Are all project deliverables complete and satisfactory?', 'max_score' => 35, 'is_active' => true],
                    ['name' => 'Presentation Quality', 'description' => 'Was the final presentation clear, engaging, and comprehensive?', 'max_score' => 35, 'is_active' => true],
                    ['name' => 'Impact/Results', 'description' => 'What is the overall impact and significance of the project results?', 'max_score' => 30, 'is_active' => true],
                ]
            ],
        ];

        foreach ($phasesData as $phaseData) {
            $phase = EvaluationPhase::firstOrCreate(
                ['name' => $phaseData['name']],
                [
                    'description' => $phaseData['description'],
                    'sequence_order' => $phaseData['sequence_order'],
                    'weight' => $phaseData['weight'],
                    'is_active' => $phaseData['is_active'],
                ]
            );

            if ($phase && !empty($phaseData['criteria'])) {
                foreach ($phaseData['criteria'] as $criterionData) {
                    RubricCriterion::firstOrCreate(
                        ['evaluation_phase_id' => $phase->id, 'name' => $criterionData['name']],
                        [
                            'description' => $criterionData['description'],
                            'max_score' => $criterionData['max_score'],
                            'is_active' => $criterionData['is_active'],
                        ]
                    );
                }
            }
        }
        $this->command->info('Seeded evaluation phases and rubric criteria.');
    }
}
