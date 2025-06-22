use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pc_parts', function (Blueprint $table) {
            $table->timestamps(); // Add created_at and updated_at columns
        });
    }

    public function down(): void
    {
        Schema::table('pc_parts', function (Blueprint $table) {
            $table->dropTimestamps(); // Remove created_at and updated_at columns
        });
    }
};
