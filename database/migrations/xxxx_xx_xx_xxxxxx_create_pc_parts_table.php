use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pc_parts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->timestamps(); // Add created_at and updated_at columns
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pc_parts');
    }
};
