<?php

namespace App\Models;

use App\Data\PathData;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Spatie\Permission\Models\Permission;

class Alliance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'acronym',
        'state',
        'domain',
        'logo',
    ];

    protected static function booted()
    {
        self::saved(function () {
            Alliance::pluck('id')->each(function (int $allianceId) {
                Permission::createOrFirst(['name' => "access alliance-id $allianceId"]);
            });
        });

        self::saving(function (self $alliance) {

            // todo: needs to support laravel's Storage, therefore it can be uploaded to any kind of storage
            if ($alliance->isDirty('logo')) {
                $filepath = PathData::from(storage_path("app/public/{$alliance->logo}"));
                $image = ImageManager::imagick()->read($filepath->toString());

                self::createScaledLogoFile($image, $filepath, 1024, 'large');
                self::createScaledLogoFile($image, $filepath, 700, 'medium');
                self::createScaledLogoFile($image, $filepath, 400, 'small');
            }
        });
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, array $attributes) => "[$this->acronym] $this->name",
        );
    }

    private static function createScaledLogoFile(
        ImageInterface $image,
        PathData $filepath,
        int $width,
        string $appendFilename
    ): void {
        $image->scaleDown($width);
        $newFilepath = clone $filepath;
        $newFilepath->filename = $newFilepath->filename.'-'.$appendFilename;
        $image->save($newFilepath->toString());
    }
}
