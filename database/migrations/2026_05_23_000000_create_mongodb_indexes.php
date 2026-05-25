<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            // Register indexes on predictions collection
            Schema::connection('mongodb')->table('predictions', function (Blueprint $collection) {
                $collection->index('user_id');
                $collection->index('email');
                $collection->index('created_at');
                $collection->index('ai.potential');
            });

            // Register indexes on users collection
            Schema::connection('mongodb')->table('users', function (Blueprint $collection) {
                $collection->index('email');
            });

            // Register indexes on analytics collection
            Schema::connection('mongodb')->table('analytics', function (Blueprint $collection) {
                $collection->index('user_id');
                $collection->index('evaluation_id');
                $collection->index('timestamp');
                $collection->index('potential');
            });
        } catch (\Throwable $e) {
            // Silently complete if connection limits are active in target environments
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::connection('mongodb')->table('predictions', function (Blueprint $collection) {
                $collection->dropIndex('predictions_user_id_index');
                $collection->dropIndex('predictions_email_index');
                $collection->dropIndex('predictions_created_at_index');
                $collection->dropIndex('predictions_ai.potential_index');
            });

            Schema::connection('mongodb')->table('users', function (Blueprint $collection) {
                $collection->dropIndex('users_email_index');
            });
        } catch (\Throwable $e) {
            // Silently complete
        }
    }
};
