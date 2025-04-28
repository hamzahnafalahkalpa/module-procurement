<?php

use Hanafalah\ModuleFunding\Models\Funding\Funding;
use Hanafalah\ModuleProcurement\Models\Supplier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Hanafalah\ModuleProcurement\Models\{
    Purchasing,
    PurchaseOrder
};

return new class extends Migration
{
    use Hanafalah\LaravelSupport\Concerns\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.PurchaseOrder', PurchaseOrder::class));
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        if (!$this->isTableExists()) {
            Schema::create($table_name, function (Blueprint $table) {
                $funding       = app(config('database.models.Funding', Funding::class));
                $supplier      = app(config('database.models.Supplier', Supplier::class));
                $purchasing    = app(config('database.models.Purchasing', Purchasing::class));

                $table->ulid('id')->primary();
                $table->unsignedBigInteger('total_cogs')->nullable();
                $table->unsignedBigInteger('total_tax')->nullable();

                $table->foreignIdFor($funding::class)->nullable()->index()
                      ->constrained()->restrictOnDelete()->cascadeOnUpdate();

                $table->foreignIdFor($supplier::class)->nullable()->index()
                      ->constrained()->restrictOnDelete()->cascadeOnUpdate();

                $table->foreignIdFor($purchasing::class)->nullable()->index()
                      ->constrained()->restrictOnDelete()->cascadeOnUpdate();
                      
                $table->json('props')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->__table->getTable());
    }
};
