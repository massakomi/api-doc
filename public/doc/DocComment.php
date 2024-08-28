<?php

namespace SimpleScribe;

/**
 * Класс для разбора doc comment на куски
 */
class DocComment
{

    /**
     * Разбирает doc комментарий метода на параметры
     * @param $comment
     * @return array
     */
    public function parse($comment)
    {
        $comment = preg_replace('~^\s*[*/]+~miu', '', $comment);
        $commentLines = array_map('trim', explode("\n", $comment));
        $lines = [];
        foreach ($commentLines as $line) {
            if (empty($line)) {
                if (!empty($lines ['title']) && !array_key_exists('desc', $lines)) {
                    $lines ['desc'] = [];
                }
                continue;
            }
            if (preg_match('~^@([a-z]+) (.*)~i', $line, $a)) {
                $this->addParams($lines, $a[1], $a[2]);
            } else {
                if (array_key_exists('desc', $lines)) {
                    $lines ['desc'][] = $line;
                } else {
                    $lines ['title'][] = $line;
                }
            }
        }
        $this->implode($lines);

        return $lines;
    }

    public function addParams(&$lines, $param, $value)
    {
        if ($param == 'responseField') {
            if (preg_match('~([a-z_.-]+) (.*)~i', $value, $b)) {
                $name = $b[1];
                $description = $b[2];
                $lines [$param][$name] = $description;
            }
        } elseif ($param == 'param') {
            if (preg_match('~([a-z]+) ([$a-z_-]+)(.*)~i', $value, $b)) {
                $type = $b[1];
                $name = $b[2];
                $description = $b[3];
                $lines [$param][$name] = [$type, $description];
            }
        } else {
            $lines [$param] = $value;
        }
    }

    public function implode(&$lines)
    {
        if ($lines ['title']) {
            $lines ['title'] = implode(' ', $lines ['title']);
        }
        if (array_key_exists('desc', $lines)) {
            if (count($lines ['desc'])) {
                $lines ['desc'] = implode(' ', $lines ['desc']);
            } else {
                unset($lines ['desc']);
            }
        }
    }
}