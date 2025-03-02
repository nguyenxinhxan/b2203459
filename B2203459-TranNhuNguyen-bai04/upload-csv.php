<!DOCTYPE html>
<html>
<head>
    <title>Upload CSV</title>
</head>
<body>
    <h2>Upload CSV File</h2>
    <form enctype="multipart/form-data" action="upload-csv-processing.php" method="post">
        Bạn hãy chọn tệp CSV để tải lên:
        <input type="file" name="csv_file" accept=".csv">
        <input type="submit" value="Upload">
    </form>
</body>
</html>
