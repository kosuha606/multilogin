<?php

namespace app\actions;

class ProfileAction extends AbstractAction
{
    public function run($provider)
    {
        $idForUser = $_GET['id'] ?? null;

        if (!$idForUser) {
            throw new \Exception('Id required');
        }

        $filename = __DIR__.'/../../storage/'.$idForUser.'.json';
        if (!is_file($filename)) {
            throw new \Exception('No data for id');
        }

        $data = file_get_contents($filename);

        return json_decode($data, true);
    }
}