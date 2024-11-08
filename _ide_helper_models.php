<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property int $main_category_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property int $status
 * @property int $position
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MainCategory $mainCategory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubCategory> $subCategories
 * @property-read int|null $sub_categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereMainCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MainCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $logo
 * @property string|null $image
 * @property string|null $colour
 * @property int $status
 * @property int $position
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubCategory> $subCategories
 * @property-read int|null $sub_categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategory whereUpdatedAt($value)
 */
	class MainCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SubCategory
 *
 * @property int $id
 * @property int $main_category_id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property int $status
 * @property int $position
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\MainCategory $mainCategory
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereMainCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubCategory whereUpdatedAt($value)
 */
	class SubCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UrlRedirect
 *
 * @property int $id
 * @property string $from_url
 * @property string $to_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UrlRedirect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UrlRedirect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UrlRedirect query()
 * @method static \Illuminate\Database\Eloquent\Builder|UrlRedirect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UrlRedirect whereFromUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UrlRedirect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UrlRedirect whereToUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UrlRedirect whereUpdatedAt($value)
 */
	class UrlRedirect extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $avatar
 * @property string $name
 * @property string $email
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VariantDetail
 *
 * @property int $id
 * @property int $variant_master_id
 * @property string $name
 * @property string $status
 * @property int $position
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\VariantMaster $variantMaster
 * @method static \Illuminate\Database\Eloquent\Builder|VariantDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantDetail wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantDetail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantDetail whereVariantMasterId($value)
 */
	class VariantDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\VariantMaster
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property int $position
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VariantMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|VariantMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantMaster whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantMaster whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantMaster wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantMaster whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VariantMaster whereUpdatedAt($value)
 */
	class VariantMaster extends \Eloquent {}
}

