<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('PhanQuyen', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('Ten', 100);
        //     $table->string('Mota', 255);
        // });

        // Schema::create('ChucVu', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('TenChucVu', 255);
        //     $table->string('MoTa', 100);
        // });

        // Schema::create('TaiKhoan', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('TenTaiKhoan')->unique();
        //     $table->string('MatKhau');
        //     $table->string('Mota', 255);
        //     $table->unsignedBigInteger('PhanQuyenId');

        //     $table->foreign('PhanQuyenId')->references('id')->on('PhanQuyen');
        // });

        // Schema::create('NhanVien', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('HoVaTen', 255);
        //     $table->string('DienThoai', 15);
        //     $table->string('GioiTinh', 1)->default('m');
        //     $table->date('NgaySinh');
        //     $table->string('DiaChi', 255);
        //     $table->unsignedBigInteger('TaiKhoanId');
        //     $table->unsignedBigInteger('ChucVuId');

        //     $table->foreign('TaiKhoanId')->references('id')->on('TaiKhoan');
        //     $table->foreign('ChucVuId')->references('id')->on('ChucVu');
        // });

        // Schema::create('BenhNhan', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('HoVaTen', 100);
        //     $table->string('DiaChi', 255);
        //     $table->string('DienThoai', 15);
        //     $table->string('NgaySinh');
        //     $table->string('CCCD');
        //     $table->timestamps();

        //     $table->index(['HoVaTen', 'DienThoai', 'CCCD']);
        // });

        // Schema::create('LoaiTinTuc', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('Ten');
        //     $table->string('DuongDan');

        //     $table->index(['Ten']);
        // });

        // Schema::create('news', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('title', 255);
        //     $table->string('desc');
        //     $table->unsignedBigInteger('created_by');
        //     $table->unsignedBigInteger('kind_news_id');
        //     $table->timestamps();

        //     $table->index(['title']);
        //     $table->foreign('created_by')->references('id')->on('users');
        //     $table->foreign('kind_news_id')->references('id')->on('kind_news');
        // });

        // Schema::create('kind_services', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('desc');

        //     $table->index(['name']);
        // });

        // Schema::create('services', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name', 255);
        //     $table->string('desc');
        //     $table->double('price')->default(0);
        //     $table->unsignedBigInteger('kind_services_id');

        //     $table->index(['name']);
        //     $table->foreign('kind_services_id')->references('id')->on('kind_services');
        // });

        // Schema::create('bills', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('code', 10);
        //     $table->string('payment', 100);
        //     $table->double('total')->default(0);
        //     $table->enum('status', ['doing', 'done', 'cancel'])->default('doing');
        //     $table->unsignedBigInteger('created_by');
        //     $table->unsignedBigInteger('patient_id');
        //     $table->timestamps();

        //     $table->index(['code']);
        //     $table->foreign('created_by')->references('id')->on('users');
        //     $table->foreign('patient_id')->references('id')->on('patients');
        // });

        // Schema::create('examination_schedule', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('patient_id');
        //     $table->unsignedBigInteger('pick_id');
        //     $table->timestamp('registration_date');

        //     $table->foreign('pick_id')->references('id')->on('users');
        //     $table->foreign('patient_id')->references('id')->on('patients');
        // });

        // Schema::create('sick_condition', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name', 255);
        //     $table->string('desc');

        //     $table->index(['name']);
        // });

        // Schema::create('health_records', function (Blueprint $table) {
        //     $table->id();
        //     $table->unsignedBigInteger('patient_id');
        //     $table->unsignedBigInteger('created_by');
        //     $table->integer('pick_id')->references('id')->on('users');
        //     $table->timestamp('day_medical');

        //     $table->foreign('created_by')->references('id')->on('users');
        //     $table->foreign('patient_id')->references('id')->on('patients');
        // });

        // Schema::create('test_results', function (Blueprint $table) {
        //     $table->unsignedBigInteger('health_records_id');
        //     $table->unsignedBigInteger('sick_condition_id');

        //     $table->primary(['health_records_id', 'sick_condition_id']);
        //     $table->foreign('health_records_id')->references('id')->on('health_records');
        //     $table->foreign('sick_condition_id')->references('id')->on('sick_condition');
        // });

        // Schema::create('promotions', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('code', 10);
        //     $table->string('desc');
        //     $table->unsignedBigInteger('created_by');
        //     $table->timestamp('start_date');
        //     $table->timestamp('end_date');

        //     $table->foreign('created_by')->references('id')->on('users');
        //     $table->index(['code']);
        // });

        // Schema::create('promotions_service', function (Blueprint $table) {
        //     $table->unsignedBigInteger('promotion_id')->references('id')->on('promotions');
        //     $table->unsignedBigInteger('servie_id')->references('id')->on('services');

        //     $table->primary(['promotion_id', 'servie_id']);
        //     $table->foreign('promotion_id')->references('id')->on('promotions');
        //     $table->foreign('servie_id')->references('id')->on('services');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('TaiKhoan', function (Blueprint $table) {
        //     $table->dropConstrainedForeignId('PhanQuyenId');
        // });
        // Schema::table('BenhNhan', function (Blueprint $table) {
        //     $table->dropIndex(['HoVaTen', 'DienThoai', 'CCCD']);
        // });
        // Schema::table('LoaiTinTuc', function (Blueprint $table) {
        //     $table->dropIndex(['Ten']);
        // });
        // Schema::table('NhanVien', function (Blueprint $table) {
        //     $table->dropConstrainedForeignId('TaiKhoanId');
        //     $table->dropConstrainedForeignId('ChucVuId');
        // });
        // Schema::dropIfExists('PhanQuyen');
        // Schema::dropIfExists('TaiKhoan');
        // Schema::dropIfExists('BenhNhan');
        // Schema::dropIfExists('LoaiTinTuc');
        // Schema::dropIfExists('ChucVu');

        // Schema::dropIfExists('news');
        // Schema::dropIfExists('services');
        // Schema::dropIfExists('kind_news');
        // Schema::dropIfExists('bills');
        // Schema::dropIfExists('promotions');
        // Schema::dropIfExists('test_results');
        // Schema::dropIfExists('health_records');
        // Schema::dropIfExists('sick_condition');
        // Schema::dropIfExists('examination_schedule');
    }
};
