<?php

namespace Src\utils;

use Exception;

class ConsoleInputHelper
{
    /**
     * @throws Exception
     */
    public static function readLine($prompt = ""): string
    {
        if ($prompt !== "") {
            echo $prompt;
        }

        $handle = fopen("php://stdin", "r");
        $line = trim(fgets($handle));
        fclose($handle);

        if (empty($line)) {
            throw new Exception("Empty value entered.");
        }

        return $line;
    }

    /**
     * @throws Exception
     */
    public static function readPassword($prompt = ""): string
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $exe = __DIR__ . DIRECTORY_SEPARATOR . 'hidden_input.exe';
            $command = "$exe";

            if ($prompt !== "") {
                $command .= " \"$prompt\"";
            }

        } else {
            $command = '/usr/bin/env bash -c \'read -s -p "' . addslashes($prompt) . '" var && echo $var\'';
        }
        $password = rtrim(shell_exec($command));

        echo "\n";

        if (empty($password)) {
            throw new Exception("Empty password entered.");
        }

        return $password;
    }
}
