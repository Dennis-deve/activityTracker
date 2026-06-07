<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityUpdate;
use App\Models\DailyActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@team.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department' => 'Applications Support',
            'phone' => '+233-800-000-0001',
            'employee_id' => 'EMP001',
        ]);

        // Create Team Members
        $member1 = User::create([
            'name' => 'Daniel Mensah',
            'email' => 'daniel@team.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'department' => 'Applications Support',
            'phone' => '+233-800-000-0002',
            'employee_id' => 'EMP002',
        ]);

        $member2 = User::create([
            'name' => 'Grace Asante',
            'email' => 'grace@team.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'department' => 'Applications Support',
            'phone' => '+233-800-000-0003',
            'employee_id' => 'EMP003',
        ]);

        $member3 = User::create([
            'name' => 'Samuel Boateng',
            'email' => 'samuel@team.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'department' => 'Network Operations',
            'phone' => '+233-800-000-0004',
            'employee_id' => 'EMP004',
        ]);

        $users = [$admin, $member1, $member2, $member3];

        // Create Activities
        $activities = [
            Activity::create([
                'title' => 'Daily SMS count in comparison to SMS count from logs',
                'description' => 'Compare the daily SMS count from the application dashboard with the count from server logs to identify discrepancies.',
                'category' => 'Monitoring',
                'is_recurring' => true,
                'is_active' => true,
                'created_by' => $admin->id,
            ]),
            Activity::create([
                'title' => 'Server Health Check',
                'description' => 'Verify all application servers are running, check CPU, memory, and disk usage.',
                'category' => 'Health Check',
                'is_recurring' => true,
                'is_active' => true,
                'created_by' => $admin->id,
            ]),
            Activity::create([
                'title' => 'Database Backup Verification',
                'description' => 'Confirm that automated database backups completed successfully and verify backup integrity.',
                'category' => 'Maintenance',
                'is_recurring' => true,
                'is_active' => true,
                'created_by' => $admin->id,
            ]),
            Activity::create([
                'title' => 'API Response Time Monitoring',
                'description' => 'Check API endpoint response times and flag any endpoints exceeding 2-second threshold.',
                'category' => 'Monitoring',
                'is_recurring' => true,
                'is_active' => true,
                'created_by' => $admin->id,
            ]),
            Activity::create([
                'title' => 'Error Log Review',
                'description' => 'Review application error logs for critical errors and escalate as needed.',
                'category' => 'Compliance',
                'is_recurring' => true,
                'is_active' => true,
                'created_by' => $admin->id,
            ]),
            Activity::create([
                'title' => 'SSL Certificate Expiry Check',
                'description' => 'Check SSL certificates for all domains and flag any expiring within 30 days.',
                'category' => 'Security',
                'is_recurring' => true,
                'is_active' => true,
                'created_by' => $admin->id,
            ]),
        ];

        // Create 7 days of sample data
        $statuses = ['done', 'pending'];
        $remarks = [
            'done' => [
                'All checks passed successfully.',
                'Completed without issues.',
                'Verified and confirmed. All values within normal range.',
                'Task completed. Report sent to team lead.',
                'Everything looks good. No anomalies detected.',
                'Done. Escalated one minor issue to the dev team.',
            ],
            'pending' => [
                'Waiting for server access to complete verification.',
                'In progress - will complete after maintenance window.',
                'Blocked by ongoing deployment. Will retry after.',
                'Partially completed. Remaining items need supervisor input.',
                'Deferred to next shift due to higher priority incident.',
            ],
        ];

        for ($day = 6; $day >= 0; $day--) {
            $date = Carbon::today()->subDays($day);

            foreach ($activities as $index => $activity) {
                $status = $day === 0 && $index >= 3 ? 'pending' : $statuses[array_rand($statuses)];
                
                $log = DailyActivityLog::create([
                    'activity_id' => $activity->id,
                    'log_date' => $date->toDateString(),
                    'current_status' => $status,
                    'assigned_to' => $users[($index + $day) % count($users)]->id,
                    'assigned_by' => $admin->id,
                    'assigned_at' => $date->copy()->setHour(8)->setMinute(0),
                ]);

                // Create 1-3 updates per log
                $updateCount = rand(1, 3);
                for ($u = 0; $u < $updateCount; $u++) {
                    $updateStatus = $u === $updateCount - 1 ? $status : 'pending';
                    $user = $users[array_rand($users)];
                    $hour = 8 + ($u * 3) + rand(0, 2);
                    $minute = rand(0, 59);

                    ActivityUpdate::create([
                        'daily_activity_log_id' => $log->id,
                        'user_id' => $user->id,
                        'status' => $updateStatus,
                        'remark' => $remarks[$updateStatus][array_rand($remarks[$updateStatus])],
                        'updated_at_time' => $date->copy()->setHour(min($hour, 18))->setMinute($minute),
                    ]);
                }
            }
        }
    }
}
