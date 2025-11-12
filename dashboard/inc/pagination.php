<?php
class Pagination
{
    public $page;
    public $offset;
    public $limit;
    public $totalPages;
    public $output = [];
    public $counter;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function page($table, $column, $limit, $join = "")
    {
        $this->limit = $limit;
        $this->page =
            isset($_GET["page"]) && is_numeric($_GET["page"])
                ? (int) $_GET["page"]
                : 1;
        $this->offset = ($this->page - 1) * $this->limit;

        $totalSql = "SELECT COUNT(*) FROM $table $join";
        $totalStmt = $this->pdo->prepare($totalSql);
        $totalStmt->execute();
        $totalRows = $totalStmt->fetchColumn();
        $this->totalPages = ceil($totalRows / $this->limit);

        $sql = "SELECT * FROM  $table $join ORDER BY $column ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":limit", $this->limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", $this->offset, PDO::PARAM_INT);
        $stmt->execute();
        $this->counter = $this->offset + 1;
        if ($stmt->rowCount() > 0) {
            while ($out = $stmt->fetch()) {
                $this->output[] = $out;
            }
        }
    }

    public function search($table, $column, $query)
    {
        $sql = "SELECT * FROM $table WHERE $column LIKE :query ORDER BY $column ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":query", "%$query%", PDO::PARAM_STR);
        $stmt->execute();
        $this->counter = $this->offset + 1;
        if ($stmt->rowCount() > 0) {
            $this->output = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function link($url)
    {
        if ($this->totalPages <= 1) {
            return "";
        }

        $html =
            '<nav aria-label="Page navigation"><ul class="pagination pagination-sm ">';

        // prev
        if ($this->page > 1) {
            $prevQuery = $_GET;
            $prevQuery["page"] = $this->page - 1;
            $html .=
                '<li class="page-item"><a class="page-link" href="' .
                $url .
                "?" .
                http_build_query($prevQuery) .
                '" aria-label="Previous">&laquo;</a></li>';
        }

        // number
        for ($i = 1; $i <= $this->totalPages; $i++) {
            $pageQuery = $_GET;
            $pageQuery["page"] = $i;
            $active = $i == $this->page ? "active" : "";
            $html .=
                '<li class="page-item ' .
                $active .
                '"><a class="page-link" href="' .
                $url .
                "?" .
                http_build_query($pageQuery) .
                '">' .
                $i .
                "</a></li>";
        }

        // next
        if ($this->page < $this->totalPages) {
            $nextQuery = $_GET;
            $nextQuery["page"] = $this->page + 1;
            $html .=
                '<li class="page-item"><a class="page-link" href="' .
                $url .
                "?" .
                http_build_query($nextQuery) .
                '" aria-label="Next">&raquo;</a></li>';
        }

        $html .= "</ul></nav>";
        return $html;
    }
}

?>
