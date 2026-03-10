<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            // 1. TAMBAH KOLOM INFORMASI DASAR
            $table->string('slug')->unique()->after('name');
            $table->string('nama_pemilik')->after('pelaku_umkm');
            $table->integer('tahun_berdiri')->nullable()->after('nama_pemilik');
            
            // 2. TAMBAH KOLOM KONTAK & SOSIAL MEDIA
            $table->string('contact_person_name')->after('whatsapp_number');
            $table->string('contact_person_phone')->after('contact_person_name');
            $table->string('email_umkm')->nullable()->after('contact_person_phone');
            $table->string('website')->nullable()->after('email_umkm');
            $table->string('facebook_link')->nullable()->after('website');
            $table->string('twitter_link')->nullable()->after('facebook_link');
            $table->string('tiktok_link')->nullable()->after('twitter_link');
            
            // 3. TAMBAH KOLOM LOKASI (detail)
            $table->string('province')->after('address');
            $table->string('city')->after('province');
            $table->string('district')->after('city');
            $table->string('village')->after('district');
            $table->string('postal_code', 10)->after('village');
            
            // 4. TAMBAH KOLOM MEDIA
            $table->string('logo')->nullable()->after('longitude');
            $table->string('thumbnail')->nullable()->after('logo');
            $table->json('gallery_images')->nullable()->after('thumbnail');
            
            // 5. TAMBAH KOLOM SEO
            $table->string('meta_title')->nullable()->after('gallery_images');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
            
            // 6. TAMBAH KOLOM SUBSCRIPTION
            $table->foreignId('subscription_plan_id')->nullable()->after('meta_keywords');
            $table->string('payment_proof')->nullable()->after('subscription_plan_id');
            $table->timestamp('subscription_start_date')->nullable()->after('payment_proof');
            $table->timestamp('subscription_end_date')->nullable()->after('subscription_start_date');
            $table->enum('subscription_status', [
                'pending', 'active', 'expired', 'cancelled', 'rejected'
            ])->default('pending')->after('subscription_end_date');
            
            // 7. TAMBAH KOLOM STATUS
            $table->enum('verification_status', [
                'pending', 'verified', 'rejected'
            ])->default('pending')->after('subscription_status');
            $table->enum('profile_status', [
                'draft', 'pending', 'published', 'archived'
            ])->default('draft')->after('verification_status');
            $table->boolean('is_featured')->default(false)->after('profile_status');
            $table->integer('views_count')->default(0)->after('is_featured');
            
            // 8. TAMBAH KOLOM ADMIN
            $table->text('admin_notes')->nullable()->after('views_count');
            $table->timestamp('verified_at')->nullable()->after('admin_notes');
            $table->foreignId('verified_by')->nullable()->after('verified_at');
            
            // 9. TAMBAH SOFT DELETES
            $table->softDeletes()->after('updated_at');
            
            // 10. TAMBAH FOREIGN KEY CONSTRAINTS UNTUK KOLOM BARU SAJA
            // JANGAN tambahkan foreign key untuk category_id karena sudah ada
            $table->foreign('subscription_plan_id')->references('id')->on('subscription_plans')->onDelete('set null');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            
            // 11. TAMBAH INDEXES untuk performance
            $table->index('slug');
            $table->index('verification_status');
            $table->index('profile_status');
            $table->index('subscription_status');
            $table->index('subscription_end_date');
            // Index untuk category_id sudah ada dari migration lama
            $table->index('pelaku_umkm');
            $table->index('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm_profiles', function (Blueprint $table) {
            // Drop foreign keys untuk kolom baru saja
            $table->dropForeign(['subscription_plan_id']);
            $table->dropForeign(['verified_by']);
            
            // Drop columns yang baru ditambahkan
            $table->dropColumn([
                'slug',
                'nama_pemilik',
                'tahun_berdiri',
                'contact_person_name',
                'contact_person_phone',
                'email_umkm',
                'website',
                'facebook_link',
                'twitter_link',
                'tiktok_link',
                'province',
                'city',
                'district',
                'village',
                'postal_code',
                'logo',
                'thumbnail',
                'gallery_images',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'subscription_plan_id',
                'payment_proof',
                'subscription_start_date',
                'subscription_end_date',
                'subscription_status',
                'verification_status',
                'profile_status',
                'is_featured',
                'views_count',
                'admin_notes',
                'verified_at',
                'verified_by',
                'deleted_at'
            ]);
            
            // Hapus indexes untuk kolom baru
            $table->dropIndex(['slug']);
            $table->dropIndex(['verification_status']);
            $table->dropIndex(['profile_status']);
            $table->dropIndex(['subscription_status']);
            $table->dropIndex(['subscription_end_date']);
            $table->dropIndex(['pelaku_umkm']);
            $table->dropIndex(['city']);
            
            // JANGAN drop index category_id karena dari migration lama
        });
    }
};