<?php

use Zahzah\ModuleProcurement\Models\Procurement;
use Zahzah\ModuleProcurement\Models\Supplier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Projects\Klinik\Models\Funding\Funding;

return new class extends Migration
{
    use Zahzah\LaravelSupport\Concerns\NowYouSeeMe;

    private $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.Procurement', Procurement::class));
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $table_name = $this->__table->getTable();
        if (! $this->isTableExists()) {
            Schema::create($table_name, function (Blueprint $table) {
                $funding = app(config('database.models.Funding', Funding::class));
                $supplier = app(config('database.models.Supplier', Supplier::class));

                $table->ulid('id')->primary();
                $table->string('author_type', 50)->nullable();
                $table->string('author_id', 36)->nullable();
                $table->timestamp('reported_at')->nullable();
                $table->unsignedBigInteger('total_cogs')->default(0)->nullable(false);

                $table->foreignIdFor($funding::class)->nullable()
                    ->index()->constrained()->cascadeOnUpdate()
                    ->nullOnDelete();

                $table->foreignIdFor($supplier::class)->nullable()
                    ->index()->constrained()->cascadeOnUpdate()
                    ->nullOnDelete();

                $table->string('warehouse_type',50)->nullable(false);
                $table->string('warehouse_id',36)->nullable(false);
                $table->string('status',50)->nullable(false);

                $table->json('props')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index(['warehouse_type','warehouse_id'],'fk_warehouse');
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
