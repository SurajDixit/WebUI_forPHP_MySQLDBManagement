<?php

include("db.php");
$sql = $_GET["query"];  
$checkType = explode(" ",$sql);
if(strtoupper($checkType[0]) == "SELECT")
{
    $result = mysqli_query($conn, $sql);
    $count = 0;
    $querysplit = explode(" ",$sql);
    $num1 = sizeof($querysplit);
    
    for($i=0;$i<$num1;$i++)
    {
        if(strtoupper($querysplit[$i]) == "FROM")
        {
            $tablename = $querysplit[$i+1];
            break;
        }
    }
    
    
    if(mysqli_num_rows($result) > 0)
        $resultCount = 1;
    else
        $resultCount = 0;
  
  //if count of tuples more than 1
    if($resultCount == 1)  
    {
        echo "<table border=1 align='center'>";
        
        //getting table headers
        $sql1 = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='".$db."' AND `TABLE_NAME`='".$tablename."'";
        $result1 = mysqli_query($conn, $sql1);
        if(mysqli_num_rows($result1) > 0)
        {
            echo "<tr>";
            while($row1 = mysqli_fetch_array($result1,MYSQLI_NUM))
            {
                $num2 = sizeof($row1);
                for($i=0;$i<$num2;$i++)
                {
                    echo "<th>".$row1[$i]."</th>";
                }
            }
            echo "</tr>";
        }
        
        //getting the contents
    
            while($row = mysqli_fetch_array($result,MYSQLI_NUM))
            {
                echo "<tr>";
                $num = sizeof($row);
                for($i=0;$i<$num;$i++)
                {
                    echo "<td>".$row[$i]."</td>";
                }
                echo "</tr>";
                $count = $count + 1;
            }
            
            //success
            echo "</table>";
            echo "<br><center>".$count." rows returned for '".$sql."'!";
            echo "<br><a href='query_form.html'>Go back to Query-form page</a></center>";
    } 
    else 
    {
        //failure
    	echo "<center>0 rows returned for '".$sql."'!<br>";
    	echo mysqli_error($conn)."<br>";
    	echo "<a href='query_form.html'>Go back to Query-form page</a></center>";
    }
}

else
{
    
    if (mysqli_query($conn, $sql)) 
    {
        //success
        echo "<center>Query '".$sql."' executed successfully<br>";
        echo "<a href='query_form.html'>Go back to Query-form page</a></center>";
    } 
    else 
    {
        //failure
        echo "<center>Query '".$sql."' did not execute!<br>";
        echo mysqli_error($conn);
        echo "<br><a href='query_form.html'>Go back to Query-form page</a></center>";
    }
}

mysqli_close($conn);

?>