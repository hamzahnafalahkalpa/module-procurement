<?php

use Hanafalah\ModuleProcurement\Models\Supplier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use Hanafalah\LaravelSupport\Concerns\NowYouSeeMe;

    private Supplier $__table;

    public function __construct()
    {
        $this->__table = app(config('database.models.Supplier', Supplier::class));
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! $this->isTableExists()) {
            Schema::create($this->getTable(), function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->longText('description')->nullable();
                $table->text('address')->nullable();
                $table->string('phone')->nullable();
                $table->fullText(['name', 'address', 'description', 'phone']);
                $table->json('props')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->getTable());
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    protected function getTable()
    {
        return $this->__table->getTable();
    }
};
