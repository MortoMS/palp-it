<?php

namespace App\Providers;

use Exception;

class ViewProvider
{
    private $data = [];
    private $path = null;

    public function setData($data)
    {
        $this->data = $data;
    }
    
    public function setPath(string $path)
    {
        $this->path = $this->pathView($path);
    }

    private function pathView(string $path): string
    {
        $viewPath = systemPath('/view/');
        $viewPath .=  systemPath($path, '.', '') . '.view.php';

        if (!file_exists($viewPath)) {
            throw new Exception(
                'Arquivo de layout não encontrado em: ' . $viewPath
            );
        }

        return $viewPath;
    }

    public static function render(string $path, $data = [])
    {
        $newView = new self;

        $newView->setPath($path);
        $newView->setData($data);

        return call_user_func($newView);
    }
    
    function __invoke()
    {
        ob_start();

        extract($this->data);

        require $this->path;
        $countext = ob_get_contents();


        ob_end_clean();

        return $countext;
    }
}
