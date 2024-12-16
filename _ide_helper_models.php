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
 * App\Models\About
 *
 * @property int $id
 * @property string $image
 * @property string $title
 * @property string|null $main_title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|About newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|About newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|About query()
 * @method static \Illuminate\Database\Eloquent\Builder|About whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|About whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|About whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|About whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|About whereMainTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|About whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|About whereUpdatedAt($value)
 */
	class About extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BannerSlider
 *
 * @property int $id
 * @property string $title
 * @property string|null $sub_title
 * @property string|null $url
 * @property string $banner
 * @property string|null $description
 * @property int $position
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider query()
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider whereSubTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BannerSlider whereUrl($value)
 */
	class BannerSlider extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $logo
 * @property string|null $colour
 * @property int $status
 * @property int $position
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereUpdatedAt($value)
 */
	class Brand extends \Eloquent {}
}

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
 * App\Models\Contact
 *
 * @property int $id
 * @property string|null $phone_one
 * @property string|null $phone_two
 * @property string|null $mail_one
 * @property string|null $mail_two
 * @property string|null $address
 * @property string|null $map_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMailOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMailTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereMapLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhoneOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhoneTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 */
	class Contact extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Counter
 *
 * @property int $id
 * @property string $counter_count_one
 * @property string $counter_name_one
 * @property string $counter_count_two
 * @property string $counter_name_two
 * @property string $counter_count_three
 * @property string $counter_name_three
 * @property string $counter_count_four
 * @property string $counter_name_four
 * @property string $counter_count_five
 * @property string $counter_name_five
 * @property string $counter_count_six
 * @property string $counter_name_six
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Counter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Counter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Counter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterCountFive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterCountFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterCountOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterCountSix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterCountThree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterCountTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterNameFive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterNameFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterNameOne($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterNameSix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterNameThree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCounterNameTwo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Counter whereUpdatedAt($value)
 */
	class Counter extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FooterInfo
 *
 * @property int $id
 * @property string|null $short_info
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $copyright
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereCopyright($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereShortInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterInfo whereUpdatedAt($value)
 */
	class FooterInfo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\HomeInfo
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $short_description
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HomeInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeInfo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeInfo whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeInfo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeInfo whereUrl($value)
 */
	class HomeInfo extends \Eloquent {}
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
 * App\Models\MainCategoryBanner
 *
 * @property int $id
 * @property int $main_category_id
 * @property string $title
 * @property string|null $sub_title
 * @property string|null $description
 * @property string|null $url
 * @property string $image
 * @property int $position
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner query()
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner whereMainCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner whereSubTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MainCategoryBanner whereUrl($value)
 */
	class MainCategoryBanner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PrivacyPolicy
 *
 * @property int $id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicy query()
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicy whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrivacyPolicy whereUpdatedAt($value)
 */
	class PrivacyPolicy extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $sku
 * @property string $name
 * @property string $slug
 * @property int $main_category_id
 * @property int $category_id
 * @property int|null $sub_category_id
 * @property string|null $description
 * @property string|null $specification
 * @property string $brand
 * @property string $material
 * @property string $units
 * @property string $weight_type
 * @property string|null $file
 * @property string|null $other_code
 * @property int|null $gst
 * @property int $has_variants
 * @property string|null $sale_price
 * @property string|null $offer_price
 * @property string|null $distributor_price
 * @property string|null $wholesale_price
 * @property int|null $min_order_qty
 * @property string|null $weight
 * @property int|null $qty
 * @property string|null $variation_ids
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property int $priority
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Category $mainCategory
 * @property-read \App\Models\Category|null $subCategory
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDistributorPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereGst($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHasVariants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMainCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMaterial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMinOrderQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOfferPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOtherCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSpecification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVariationIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeightType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWholesalePrice($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $variant_id
 * @property string $image_path
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereVariantId($value)
 */
	class ProductImage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductVariant
 *
 * @property int $id
 * @property int $product_id
 * @property string $variation_code
 * @property string $sku
 * @property string|null $sale_price
 * @property string|null $offer_price
 * @property string|null $distributor_price
 * @property string|null $wholesale_price
 * @property int $min_order_qty
 * @property string|null $weight
 * @property int $qty
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductImage> $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereDistributorPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereMinOrderQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereOfferPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereVariationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariant whereWholesalePrice($value)
 */
	class ProductVariant extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReturnPolicy
 *
 * @property int $id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnPolicy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnPolicy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnPolicy query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnPolicy whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnPolicy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnPolicy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnPolicy whereUpdatedAt($value)
 */
	class ReturnPolicy extends \Eloquent {}
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
 * App\Models\ShippingPolicy
 *
 * @property int $id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingPolicy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingPolicy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingPolicy query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingPolicy whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingPolicy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingPolicy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShippingPolicy whereUpdatedAt($value)
 */
	class ShippingPolicy extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SocialLink
 *
 * @property int $id
 * @property string $icon
 * @property string $name
 * @property string $link
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereUpdatedAt($value)
 */
	class SocialLink extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
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
 * App\Models\Subscriber
 *
 * @property int $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereUpdatedAt($value)
 */
	class Subscriber extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TermsAndCondition
 *
 * @property int $id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermsAndCondition whereUpdatedAt($value)
 */
	class TermsAndCondition extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VariantDetail> $details
 * @property-read int|null $details_count
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

