<?php
namespace Serff\Cms\Modules\Core\ThemesModule\Core;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 * Class Theme
 *
 * @package Serff\Cms\Modules\Core\ThemesModule\Core
 */
abstract class Theme
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $viewPath;
    /**
     * @var string
     */
    protected $assetsPath;
    /**
     * @var string
     */
    protected $author;
    /**
     * @var string
     */
    protected $author_image_path;
    /**
     * @var string
     */
    protected $screen_shot;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $admin_wysiwyg_css;
    /**
     * @var bool
     */
    protected $hidden = false;
    /**
     * @var array
     */
    protected $templates = [];
    /**
     * @var bool
     */
    protected $multi_level_navigation = false;

    /**
     * abstract boot class to be extended
     */
    public function boot()
    {
        if ($this->hidden) {
            return;
        }
        $path = $this->getViewPath();
        \View::addLocation($path);
        \View::addNamespace($this->getName(), $path);
        
        $this->checkAssetsSymlink();
        
        if (get_option('selected_theme', '') == get_class($this)) {
            app('Container')->setActiveTheme($this);
        }
    }

    /**
     * @return string
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Str::slug(Str::lower($this->name));
    }

    /**
     * @return string
     */
    public function getNameFormatted()
    {
        return Str::ucfirst($this->name);
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @return array
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getTemplateData($slug)
    {
        foreach($this->templates as $template) {
            if(array_get($template, 'slug') == $slug) {
                return $template;
            }
        }
    }

    /**
     * @param $name
     * @param $view
     */
    protected function registerTemplate($name, $view)
    {
        $this->templates[] = ['name' => $name, 'slug' => Str::slug($name), 'view' => $view];
    }

    /**
     * @return string
     */
    public function getAuthorImagePath()
    {
        if ($this->author_image_path === null) {
            return 'https://placeholdit.imgix.net/~text?txtsize=33&txt=200%C3%97200&w=200&h=200';
        }

        return $this->author_image_path;
    }

    /**
     * @return string
     */
    public function getScreenShot()
    {
        if ($this->screen_shot === null) {
            return 'https://placeholdit.imgix.net/~text?txtsize=33&txt=1024%C3%97768&w=1024&h=768';
        }
        /**
         * @var Image $image
         */
        $image_path = public_path($this->screen_shot);
        $image = Image::make($image_path);
        if ($image->getWidth() > 600) {
            $image->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save($image_path, 90);
        }

        return $this->screen_shot;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getAdminWysiwygCss()
    {
        if ($this->admin_wysiwyg_css === null) {
            return null;
        }
        $file = public_path($this->admin_wysiwyg_css);
        $lessc = new \lessc();
        $target_css_file_relative = '/themes/cache/' . $this->getName() . '-editor.css';
        $target_less_file_relative = '/themes/cache/' . $this->getName() . '-editor.less';

        if (\File::exists($file)) {
            $css_content = \File::get($file);
            $hash = md5($css_content);
            $option_key = $this->getName() . '.editor-hash';
            if ((get_option($option_key, '') != $hash) || (\File::exists(public_path($target_css_file_relative)) == false)) {
                $content = ".redactor-editor {\n" . $css_content . "\n }";
                $less_file = public_path($target_less_file_relative);
                \File::put($less_file, $content);
                $target_css = str_replace('.less', '.css', $less_file);
                $lessc->compileFile($less_file, $target_css);
                set_option($option_key, $hash);
            }

            return $target_css_file_relative;
        }

        return $this->admin_wysiwyg_css;
    }

    /**
     * Create a symlink to assets if not found
     */
    protected function checkAssetsSymlink()
    {
        if(is_null($this->assetsPath)) {
            return;
        }
        if(!\File::exists($this->assetsPath)) {
            return;
        }
        
        $dir_name = \File::basename($this->assetsPath);
        $symlink_target = public_path('themes/' . $dir_name);
        
        if(!\File::exists($symlink_target)) {
            symlink($this->assetsPath, $symlink_target);
        }
    }
}