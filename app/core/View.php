<?php

namespace MasterStudents\Core;

class View
{
    private string $DEFAULT_LAYOUT_DIRECTORY = LAYOUTS_PATH;
    private string $DEFAULT_DIRECTORY = VIEWS_PATH;
    private string $DEFAULT_EXTENSION = ".view.php";
    private string $DEFAULT_LAYOUT = "frontend";

    protected string $name = "";
    protected string $view_path = "";
    protected string $default_layout_path = "";
    protected string $layout_path = "";
    protected array $data = [];

    // quiz.response
    public function __construct($path, array $data = [])
    {
        $path = explode(".", $path);
        $index = count($path) - 1;

        if (count($path) == 0) return false;

        $this->name = $path[$index];
        unset($path[$index]);

        if (count($path) > 0) $this->layout_path = $this->getFile($path[0], true);

        $path = implode("/", $path) . (count($path) > 0 ? "/" : "") . $this->name;
        $this->view_path = $this->getFile($path);
        $this->default_layout_path = $this->getFile($this->DEFAULT_LAYOUT, true);
        $this->data = $data;

        return $this;
    }

    public static function view($path, array $data = [])
    {
        return new Self($path, $data);
    }

    public function render()
    {
        foreach ($this->data as $name => $value) {
            global $$name;
            $$name = $value;
        }

        $layout_content = $this->layoutContent();
        $view_content = $this->viewContent();

        return str_replace("{{ content }}", $view_content, $layout_content);
    }

    protected function layoutContent()
    {
        ob_start();
        if (file_exists($this->layout_path)) {
            include_once $this->layout_path;
        } else {
            include_once $this->default_layout_path;
        }

        return ob_get_clean();
    }

    protected function viewContent()
    {
        ob_start();
        if (file_exists($this->view_path)) {
            include_once $this->view_path;
        } else {
            include_once $this->view_path;
        }

        return ob_get_clean();
    }

    protected function getFile($path, bool $is_layout = false)
    {
        return ($is_layout ? $this->DEFAULT_LAYOUT_DIRECTORY : $this->DEFAULT_DIRECTORY) . $path . $this->DEFAULT_EXTENSION;
    }
}
