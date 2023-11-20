<?php

class HtmlHelper
{
    public static function Header($text)
    {
        echo "<h1>$text</h1>";
    }
    public static function Link($url, $title, $newTab = false)
    {
        $target = $newTab ? "target='_blank'" : "";
        return "<a href='$url' $target>$title</a>";
    }

    const FaviconGoogleServiceURL = "http://www.google.com/s2/favicons?sz=64&domain=";
    public static function SiteFavicon($url)
    {
        $faviconUrl = self::FaviconGoogleServiceURL . $url;
        return "<img class='favicon' src='$faviconUrl'>";
    }

    public static function ComboBox($DOM_Id, $items, $selectedItem = "")
    {
        $html = "<select id='$DOM_Id' class='form-control'>";
        $selected = $selectedItem == "" ? "selected" : "";
        foreach ($items as $item) {
            $selected = $item == $selectedItem ? "selected" : "";
            $html .= "<option $selected>$item</option>";
        }
        $html .= "</select>";
        return $html;
    }

    public static function Groupbox($title, $name, $items, $selectedItem = "")
    {
        $html = "<fieldset>";
        $html .= " <legend>$title</legend>";
        $index = 0;
        $html .= "<div class='groupBox'>";
        foreach ($items as $item) {
            $id = $name . $index;
            $checked = $item == $selectedItem ? "checked" : "";
            $html .= "<input type='radio' name='$name' id='$id' $checked value='$index' />";
            $html .= "<label for='$id'>$item</label>";
            $index++;
        }
        $html .= "</div>";
        $html .= "</fieldset>";
        return $html;
    }

    public static function Table($tableRows, $tableTitle = "", $columnTitles = [])
    {
        $html = "";
        if (count($tableRows) > 0) {
            $html .= "<table>";
            if ($tableTitle != "") {
                $nbColumns = count($tableRows[0]);
                $html .= "<tr>";
                $html .= "<th colspan='$nbColumns' style='text-align:center; font-size:large'>$tableTitle</th>";
                $html .= "</tr>";
            }
            if (count($columnTitles) > 0) {
                $html .= "<tr>";
                foreach ($columnTitles as $title) {
                    $html .= "<th>$title</th>";
                }
                $html .= "</tr>";
            }
            foreach ($tableRows as $rowItems) {
                $html .= "<tr>";
                foreach ($rowItems as $item) {
                    $html .= "<td>$item</td>";
                }
                $html .= "</tr>";
            }
            $html .= "</table>";
            return $html;
        }
    }
} 