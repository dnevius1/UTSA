<?php

// Database connection parameters
$servername = "localhost";
$username = "webuser";
$password = "!Ra/hRdebnnICOzV";
$dbname = "test";

// CSV file path and name
$csvfile = "/home/ubuntu/equipment2aj";

$count=0;
$time_start=microtime(true);
echo "<p>Start time is: $time_start</p>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create table if it does not exist
$sql = "CREATE TABLE IF NOT EXISTS equipment (
    type VARCHAR(15) NOT NULL,
    manufacturer VARCHAR(15) NOT NULL,
    serial_num VARCHAR(37) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully\n";
} else {
    echo "Error creating table: " . $conn->error;
}

// Prepare the SQL query for inserting data
$sql = "INSERT INTO equipment (type, manufacturer, serial_num) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $type, $manufacturer, $serial_num);

// Read the CSV file
$row = 1;

$sql="Set autocommit=0";
$conn->query($sql) or
		die("Something went wrong with $sql<br>\n".$conn->error);

if (($handle = fopen($csvfile, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        
        // Set the values for the prepared statement
        $type = $data[0];
        $manufacturer = $data[1];
        $serial_num = $data[2];

        // Execute the prepared statement
        if ($stmt->execute()) {
            $count++;
        } else {
            echo "Error inserting row " . $row . ": " . $stmt->error . "\n";
        }

        $row++;
    }
    fclose($handle);
}

$sql="COMMIT";
$conn->query($sql) or
		die("Something went wrong with $sql<br>\n".$conn->error);

$time_end=microtime(true);
echo "<p>End Time:$time_end</p>\n";
$seconds=$time_end-$time_start;
$execution_time=($seconds)/60;
echo "<p>Execution time: $execution_time minutes or $seconds seconds.</p>\n";
$rowsPerSecond=$count/$seconds;
echo "<p>Insert rate: $rowsPerSecond per second</p>\n";

// Close the database connection
$conn->close();

?>
