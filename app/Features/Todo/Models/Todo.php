<?php declare(strict_types=1);

namespace App\Features\Todo\Models;

use App\Features\Auth\Models\User;
use App\Features\Todo\Resources\TodoResourceCollection;
use App\Features\User\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy([UserScope::class])]
#[UseResourceCollection(TodoResourceCollection::class)]
class Todo extends Model
{
    use HasFactory;

    protected $table = 'todos';

    protected $fillable = [
        'title',
        'description',
        'completed',
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];

    protected $attributes = [
        'description' => '',
        'completed' => false,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
