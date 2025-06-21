<?php
// list_tables_enhanced.php
$serverName = "DESKTOP-PMNDNNT";
$database = "Emanger";
$username = "sa";
$password = "1";

try {
    $conn = new PDO(
        "sqlsrv:Server=$serverName;Database=$database", 
        $username, 
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::SQLSRV_ATTR_QUERY_TIMEOUT => 5
        ]
    );
    
    echo "<h2>Tables in Database: $database</h2>";
    
    // Search functionality
    echo '<form method="get">
            Search tables: <input type="text" name="search" value="'.($_GET['search']??'').'">
            <input type="submit" value="Search">
          </form>';
    
    // Query with optional search
    $search = $_GET['search'] ?? '';
    $query = "SELECT TABLE_NAME 
              FROM INFORMATION_SCHEMA.TABLES 
              WHERE TABLE_TYPE = 'BASE TABLE' 
              AND TABLE_CATALOG = ?
              ".($search ? "AND TABLE_NAME LIKE ?" : "")."
              ORDER BY TABLE_NAME";
    
    $stmt = $conn->prepare($query);
    $params = [$database];
    if ($search) $params[] = "%$search%";
    $stmt->execute($params);
    
    // Display results
    echo "<table border='1' cellpadding='5' style='width:100%'>";
    echo "<tr>
            <th>Table Name</th>
            <th>Row Count</th>
            <th>Actions</th>
          </tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tableName = $row['TABLE_NAME'];
        $count = $conn->query("SELECT COUNT(*) FROM [$tableName]")->fetchColumn();
        
        echo "<tr>
                <td>$tableName</td>
                <td align='right'>".number_format($count)."</td>
                <td>
                    <a href='view_table.php?table=$tableName'>View Data</a> | 
                    <a href='export_table.php?table=$tableName&format=csv'>CSV</a> |
                    <a href='export_table.php?table=$tableName&format=json'>JSON</a>
                </td>
              </tr>";
    }
    echo "</table>";
    
} catch (PDOException $e) {
    echo "<div style='color:red'>Error: ".$e->getMessage()."</div>";
}
?>
<?php
// view_table.php
if (!isset($_GET['table'])) die("No table specified");

$tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['table']);
$page = max(1, $_GET['page'] ?? 1);
$perPage = 50;
$offset = ($page - 1) * $perPage;

try {
    $conn = new PDO(
        "sqlsrv:Server=DESKTOP-PMNDNNT;Database=Emanger", 
        "sa", 
        "1",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::SQLSRV_ATTR_QUERY_TIMEOUT => 5
        ]
    );
    
    // Get columns
    $columns = $conn->query("
        SELECT COLUMN_NAME, DATA_TYPE 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = '$tableName'
        ORDER BY ORDINAL_POSITION
    ")->fetchAll(PDO::FETCH_ASSOC);
    
    // Get data with pagination
    $data = $conn->query("
        SELECT * FROM (
            SELECT *, ROW_NUMBER() OVER (ORDER BY (SELECT NULL)) as row_num 
            FROM [$tableName]
        ) t 
        WHERE row_num BETWEEN $offset AND ".($offset + $perPage)."
    ")->fetchAll(PDO::FETCH_ASSOC);
    
    // Get total count
    $total = $conn->query("SELECT COUNT(*) FROM [$tableName]")->fetchColumn();
    
    // Display
    echo "<h2>Data in Table: $tableName</h2>";
    echo "<p>Showing ".count($data)." of ".number_format($total)." records</p>";
    echo "<p><a href='list_tables_enhanced.php'>Back to Tables List</a></p>";
    
    // Pagination
    $totalPages = ceil($total / $perPage);
    if ($totalPages > 1) {
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $page) {
                echo "<strong>$i</strong> ";
            } else {
                echo "<a href='?table=$tableName&page=$i'>$i</a> ";
            }
        }
        echo "</div>";
    }
    
    // Table data
    echo "<table border='1' cellpadding='5' style='width:100%;overflow-x:auto'>";
    echo "<tr>";
    foreach ($columns as $col) {
        echo "<th title='".$col['DATA_TYPE']."'>".$col['COLUMN_NAME']."</th>";
    }
    echo "</tr>";
    
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($columns as $col) {
            $value = $row[$col['COLUMN_NAME']] ?? 'NULL';
            echo "<td>".htmlspecialchars($value)."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
    
} catch (PDOException $e) {
    echo "<div style='color:red'>Error: ".$e->getMessage()."</div>";
}
?>