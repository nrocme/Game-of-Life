
<!DOCTYPE html>
<html>
<head>
    <title> A Dynamic PHP table </title>
    <meta charset='utf-8'>
    <style>
        table { 
            border: 1px solid black; 
            border-spacing: 0px;
        }
        td { 
            border: 1px solid black; 
            border-spacing: 0px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <form> 
        <table>
            <tr>
                <td> <input type='text' id='rows' placeholder="# of rows"> 
                <td> <input type='text' id='col'  placeholder="# of cols">
            <tr>
                <td><input type='reset'>
                <td align=center><input type='submit'>
            <tr>
                <td colspan=2 align=center><input id="clickMe" type="button" value="Start" onclick="func();">
        </table>
    </form>
<table id="table1">
<tbody>
<?php
    $rows=isset($_POST['rows'])? htmlspecialchars($_POST['rows']) : 250;
    $cols=isset($_POST['cols'])? htmlspecialchars($_POST['cols']) : 250;
    for($r = 0; $r < $rows; $r++) {
        echo "<tr>";
        for($c = 0; $c < $cols; $c++) echo "<td onclick='swapState(event);'>";
        echo "\n";
    } 
?>
<script>
    // make game out of this where you much m,athc a later genration
    var table = document.getElementById('table1');
    var rows = 250;
    var cols = 250;
    
    function func() 
    {
        var r, c, count, cell;
        // empty array that will later be filled with the cells that need switched from dead to alive or vis versa
        var a = [];
        for(r = 0; r < rows; r++) {
            for(c = 0; c < cols; c++) {
                var cell  = table.rows[r].cells[c];
                count = liveNeigbours(cell, r, c);
                if(isAlive(cell)) {
                    if(count == 2 || count == 3)  continue;
                    else a.push([r,c]);
                }
                else {
                    if(count >= 3) a.push([r,c]);
                }
            }
        }
        swapStates(a);
        setTimeout(func, 10);
    }
    
    // takes an array that has all the states that needs changed and flips their value 
    function swapStates(a)
    {
        for(var i = 0; i < a.length; i++) {
            if(isAlive(table.rows[a[i][0]].cells[a[i][1]])) kill(table.rows[a[i][0]].cells[a[i][1]]);
            else revive(table.rows[a[i][0]].cells[a[i][1]]);
        }
    }
    
    function swapState(e)
    {
            var cell = e.target;
            if(isAlive(cell)) kill(cell);
            else revive(cell);
    }
    
    function beep() {
        console.log("peep");
    }
    // checks if the cell is alive or dead
    function isAlive(cell)
    {
        if(cell.style.backgroundColor == 'black') return 1;
        else return 0;
    }
    
    // Sets the cell as alive
    function revive(cell) 
    {
        cell.setAttribute('style', 'background-color:black;');
    }
    
    // Sets the cell as dead
    function kill(cell) 
    {
        cell.setAttribute('style', 'background-color:white;');
    }
    
    
    function liveNeigbours(cell, r, c)
    {
        var count = 0;
        if(r - 1 != -1){
            if(c - 1 != -1) if(isAlive(table.rows[r-1].cells[c-1])) count++;
            if(c + 1 < cols) if(isAlive(table.rows[r-1].cells[c+1])) count++;
            if(isAlive(table.rows[r-1].cells[c])) count++;
        }
        if(r + 1 < rows){
            if(c - 1 != -1)  if(isAlive(table.rows[r+1].cells[c-1])) count++;
            if(c + 1 < cols) if(isAlive(table.rows[r+1].cells[c+1])) count++;
            if(isAlive(table.rows[r+1].cells[c])) count++;
        }
        
        if(c - 1 != -1) if(isAlive(table.rows[r].cells[c-1])) count++;
        if(c + 1 < cols) if(isAlive(table.rows[r].cells[c+1])) count++;
        return count;
    }
</script>
</tbody>
</table>
</body>
</html>
