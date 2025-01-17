<?php

namespace App\Models\Traits;

trait HasMetas
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function getMetaDataAttribute()
    {
        return $this->metas->pluck('meta_value', 'meta_key');
    }

    public function updateMeta($meta_key, $meta_value)
    {
        $this->metas()->updateOrCreate(['meta_key' => $meta_key], ['meta_value' => $meta_value]);
    }

    public function removeMeta($meta_key)
    {
        $this->metas()->where('meta_key', $meta_key)->delete();
    }

    /**
     * @param $meta_keys string|array
     * @return void
     */
    public function removeMetas($meta_keys)
    {
        if (!is_array($meta_keys)) {
            $meta_keys = [$meta_keys];
        }
        $this->metas()->whereIn('meta_key', $meta_keys)->delete();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getMetas()
    {
        return $this->metas->pluck('meta_value', 'meta_key');
    }

    /**
     * @param $meta_key
     * @param $default
     * @return mixed
     */
    public function getMeta($meta_key, $default = null)
    {
        return $this->getMetas()->get($meta_key, $default);
    }
}