<?php

namespace common;

class Helper {

    /**
     * @param array<mixed> $data
     */
    public static function printRFormatted($data):void {
        echo "<pre>";
        print_r($data);
        echo "<pre>";
    }

    public static function getKey(string|int|float $x, string|int|float $y): string {
        return $x .",". $y;
    }

    /**
     * @return array<int|string>
     */
    public static function getCoordsFromKey(string $key) {
        return explode(",", $key);
    }

    /**
     * @param array<mixed> $tableData
     */
    public static function showDataAsTable($tableData): string {
        $html = "<table border='1' style='border-collapse: collapse;'>\n";
        $html .= "<th>";
        for($i=0; $i<count($tableData[0]); $i++) {
            $html .= "<td>". $i ."</td>";
        }
        $html .= "</th>";
        foreach($tableData as $key => $row) {
            $html .="<tr>";
            $html .="<td>". $key ."</td>";
            for($i=0; $i<count($tableData[0]); $i++) {
                $html .= "<td>". $row[$i] ."</td>";
            }
            $html .= "</tr>";
        }
        return $html;
    }
}