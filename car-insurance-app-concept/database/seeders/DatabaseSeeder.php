<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Owner;
use App\Models\Car;
use App\Models\Driver;
use App\Models\CoverageType;
use App\Models\Policy;
use App\Models\Claim;
use App\Models\Payment;
use App\Models\Quote;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user if not exists
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create coverage types
        $coverageTypes = [
            [
                'name' => 'Third Party Liability',
                'description' => 'Covers damage to third parties and their property',
                'base_premium' => 5.0,
                'type' => 'percentage',
                'is_active' => true,
                'is_mandatory' => true,
            ],
            [
                'name' => 'Collision Coverage',
                'description' => 'Covers damage to your vehicle from collisions',
                'base_premium' => 8.0,
                'type' => 'percentage',
                'is_active' => true,
                'is_mandatory' => false,
            ],
            [
                'name' => 'Comprehensive Coverage',
                'description' => 'Covers non-collision damage (theft, weather, etc.)',
                'base_premium' => 6.0,
                'type' => 'percentage',
                'is_active' => true,
                'is_mandatory' => false,
            ],
            [
                'name' => 'Personal Injury Protection',
                'description' => 'Covers medical expenses for you and your passengers',
                'base_premium' => 500.0,
                'type' => 'fixed',
                'is_active' => true,
                'is_mandatory' => false,
            ],
            [
                'name' => 'Uninsured Motorist',
                'description' => 'Covers damage caused by uninsured drivers',
                'base_premium' => 300.0,
                'type' => 'fixed',
                'is_active' => true,
                'is_mandatory' => false,
            ],
            [
                'name' => 'Roadside Assistance',
                'description' => '24/7 roadside assistance and towing',
                'base_premium' => 100.0,
                'type' => 'fixed',
                'is_active' => true,
                'is_mandatory' => false,
            ],
        ];

        foreach ($coverageTypes as $coverageData) {
            CoverageType::create($coverageData);
        }

        // Create owners
        $owners = [
            [
                'name' => 'John',
                'surname' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+1-555-0101',
                'address' => '123 Main St, Springfield, IL 62701',
                'date_of_birth' => '1985-06-15',
            ],
            [
                'name' => 'Jane',
                'surname' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+1-555-0102',
                'address' => '456 Oak Ave, Springfield, IL 62702',
                'date_of_birth' => '1990-03-22',
            ],
            [
                'name' => 'Robert',
                'surname' => 'Johnson',
                'email' => 'robert.johnson@example.com',
                'phone' => '+1-555-0103',
                'address' => '789 Pine Rd, Springfield, IL 62703',
                'date_of_birth' => '1978-11-08',
            ],
            [
                'name' => 'Emily',
                'surname' => 'Williams',
                'email' => 'emily.williams@example.com',
                'phone' => '+1-555-0104',
                'address' => '321 Elm St, Springfield, IL 62704',
                'date_of_birth' => '1995-01-30',
            ],
            [
                'name' => 'Michael',
                'surname' => 'Brown',
                'email' => 'michael.brown@example.com',
                'phone' => '+1-555-0105',
                'address' => '654 Maple Dr, Springfield, IL 62705',
                'date_of_birth' => '1982-09-12',
            ],
        ];

        foreach ($owners as $ownerData) {
            Owner::create($ownerData);
        }

        // Create cars
        $cars = [
            [
                'reg_number' => 'ABC-123',
                'vin' => '1HGBH41JXMN109186',
                'brand' => 'Toyota',
                'model' => 'Camry',
                'year' => 2022,
                'color' => 'Silver',
                'vehicle_type' => 'sedan',
                'mileage' => 15000,
                'owner_id' => 1,
            ],
            [
                'reg_number' => 'XYZ-789',
                'vin' => '2FMDK3GC8DBA12345',
                'brand' => 'Honda',
                'model' => 'CR-V',
                'year' => 2021,
                'color' => 'Blue',
                'vehicle_type' => 'suv',
                'mileage' => 28000,
                'owner_id' => 2,
            ],
            [
                'reg_number' => 'DEF-456',
                'vin' => '3VWDX7AJ9DM123456',
                'brand' => 'BMW',
                'model' => '3 Series',
                'year' => 2023,
                'color' => 'Black',
                'vehicle_type' => 'sedan',
                'mileage' => 5000,
                'owner_id' => 3,
            ],
            [
                'reg_number' => 'GHI-321',
                'vin' => '5XYZUDLB8FG123456',
                'brand' => 'Ford',
                'model' => 'F-150',
                'year' => 2020,
                'color' => 'White',
                'vehicle_type' => 'truck',
                'mileage' => 45000,
                'owner_id' => 4,
            ],
            [
                'reg_number' => 'JKL-654',
                'vin' => 'WA1LAAF77JD123456',
                'brand' => 'Tesla',
                'model' => 'Model 3',
                'year' => 2024,
                'color' => 'Red',
                'vehicle_type' => 'sedan',
                'mileage' => 2000,
                'owner_id' => 5,
            ],
        ];

        foreach ($cars as $carData) {
            Car::create($carData);
        }

        // Create drivers
        $drivers = [
            [
                'owner_id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+1-555-0101',
                'license_number' => 'D1234567',
                'license_state' => 'IL',
                'license_country' => 'US',
                'date_of_birth' => '1985-06-15',
                'license_expiry' => '2028-06-15',
                'is_primary' => true,
            ],
            [
                'owner_id' => 1,
                'first_name' => 'Sarah',
                'last_name' => 'Doe',
                'email' => 'sarah.doe@example.com',
                'phone' => '+1-555-0199',
                'license_number' => 'D7654321',
                'license_state' => 'IL',
                'license_country' => 'US',
                'date_of_birth' => '1987-04-20',
                'license_expiry' => '2027-04-20',
                'is_primary' => false,
            ],
            [
                'owner_id' => 2,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+1-555-0102',
                'license_number' => 'S2345678',
                'license_state' => 'IL',
                'license_country' => 'US',
                'date_of_birth' => '1990-03-22',
                'license_expiry' => '2026-03-22',
                'is_primary' => true,
            ],
        ];

        foreach ($drivers as $driverData) {
            Driver::create($driverData);
        }

        // Create policies
        $user = User::first();
        $policies = [
            [
                'policy_number' => 'POL-' . date('Y') . '-000001',
                'owner_id' => 1,
                'car_id' => 1,
                'user_id' => $user->id,
                'start_date' => '2025-01-01',
                'end_date' => '2026-12-31',
                'status' => 'active',
                'total_premium' => 1200.00,
                'payment_frequency' => 'monthly',
                'deductible' => 500.00,
            ],
            [
                'policy_number' => 'POL-' . date('Y') . '-000002',
                'owner_id' => 2,
                'car_id' => 2,
                'user_id' => $user->id,
                'start_date' => '2025-03-15',
                'end_date' => '2026-03-14',
                'status' => 'active',
                'total_premium' => 1500.00,
                'payment_frequency' => 'quarterly',
                'deductible' => 750.00,
            ],
            [
                'policy_number' => 'POL-' . date('Y') . '-000003',
                'owner_id' => 3,
                'car_id' => 3,
                'user_id' => $user->id,
                'start_date' => '2025-06-01',
                'end_date' => '2026-05-31',
                'status' => 'active',
                'total_premium' => 2000.00,
                'payment_frequency' => 'annually',
                'deductible' => 1000.00,
            ],
            [
                'policy_number' => 'POL-' . date('Y') . '-000004',
                'owner_id' => 4,
                'car_id' => 4,
                'user_id' => $user->id,
                'start_date' => '2024-01-01',
                'end_date' => '2025-01-15', // Expiring soon
                'status' => 'active',
                'total_premium' => 1800.00,
                'payment_frequency' => 'monthly',
                'deductible' => 500.00,
            ],
        ];

        foreach ($policies as $policyData) {
            $policy = Policy::create($policyData);
            
            // Attach coverages
            $coverageTypes = CoverageType::limit(3)->get();
            foreach ($coverageTypes as $index => $coverage) {
                $policy->coverages()->attach($coverage, [
                    'coverage_limit' => ($index + 1) * 10000,
                    'deductible' => 500,
                    'premium_amount' => $policy->total_premium / ($index + 1),
                ]);
            }
        }

        // Create claims
        Claim::create([
            'claim_number' => 'CLM-' . date('Y') . '-000001',
            'policy_id' => 1,
            'driver_id' => 1,
            'user_id' => $user->id,
            'incident_date' => '2025-11-15 14:30:00',
            'description' => 'Rear-ended at traffic light. Minor damage to rear bumper.',
            'location' => 'Main St & 5th Ave, Springfield, IL',
            'police_report_number' => 'SPD-2025-12345',
            'damage_amount' => 2500.00,
            'estimated_payout' => 2000.00,
            'status' => 'approved',
            'adjuster_notes' => 'Claim approved. Damage assessment completed.',
            'filed_date' => '2025-11-16',
            'approved_date' => '2025-11-20',
        ]);

        Claim::create([
            'claim_number' => 'CLM-' . date('Y') . '-000002',
            'policy_id' => 2,
            'driver_id' => 3,
            'user_id' => $user->id,
            'incident_date' => '2025-12-01 09:15:00',
            'description' => 'Vehicle damaged in parking lot. Unknown party.',
            'location' => 'Shopping Center, Springfield, IL',
            'damage_amount' => 1500.00,
            'estimated_payout' => 1200.00,
            'status' => 'investigating',
            'adjuster_notes' => 'Investigation in progress.',
            'filed_date' => '2025-12-02',
        ]);

        Claim::create([
            'claim_number' => 'CLM-' . date('Y') . '-000003',
            'policy_id' => 3,
            'driver_id' => null,
            'user_id' => $user->id,
            'incident_date' => '2025-12-10 18:45:00',
            'description' => 'Windshield cracked due to road debris.',
            'location' => 'Highway I-55, Springfield, IL',
            'damage_amount' => 800.00,
            'estimated_payout' => 600.00,
            'status' => 'filed',
            'filed_date' => '2025-12-11',
        ]);

        // Create payments
        $activePolicies = Policy::where('status', 'active')->get();
        foreach ($activePolicies as $policy) {
            for ($i = 1; $i <= 3; $i++) {
                Payment::create([
                    'policy_id' => $policy->id,
                    'amount' => $policy->total_premium / 12,
                    'payment_date' => now()->subMonths($i),
                    'due_date' => now()->subMonths($i)->addDays(5),
                    'status' => 'paid',
                    'payment_method' => 'card',
                    'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                    'payment_number' => $i,
                    'is_recurring' => true,
                ]);
            }
            
            // Create upcoming payment
            Payment::create([
                'policy_id' => $policy->id,
                'amount' => $policy->total_premium / 12,
                'payment_date' => now()->addDays(15),
                'due_date' => now()->addDays(15),
                'status' => 'pending',
                'payment_method' => 'card',
                'payment_number' => 4,
                'is_recurring' => true,
            ]);
        }

        // Create quotes
        Quote::create([
            'quote_number' => 'QT-' . date('Y') . '-000001',
            'owner_id' => 5,
            'car_id' => 5,
            'user_id' => $user->id,
            'estimated_premium' => 1800.00,
            'coverages' => ['liability' => 100000, 'collision' => 50000, 'comprehensive' => 50000],
            'status' => 'pending',
            'expires_at' => now()->addDays(15),
        ]);

        Quote::create([
            'quote_number' => 'QT-' . date('Y') . '-000002',
            'owner_id' => 1,
            'car_id' => 1,
            'user_id' => $user->id,
            'estimated_premium' => 2200.00,
            'coverages' => ['liability' => 200000, 'collision' => 100000, 'comprehensive' => 100000],
            'status' => 'converted',
            'converted_to_policy_id' => Policy::first()->id,
            'expires_at' => now()->subDays(30),
        ]);
    }
}
