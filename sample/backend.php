	<?php
    if(isset($_POST['functionname']))
    {
        $paPDO = initDB();
        $paSRID = '4326';
        

        $functionname = $_POST['functionname'];


        if($functionname != 'getWhereFoodStore' && $functionname != 'getTree'){
            $paPoint = $_POST['paPoint'];
        }

        if(isset($_POST['paTreeTime'])){
            $paTree = $_POST['paTreeTime'];
        }
       
        $aResult = "null";
        if ($functionname == 'getGeoCMRToAjax')
            $aResult = getGeoCMRToAjax($paPDO, $paSRID, $paPoint);
        else if ($functionname == 'getRiverToAjax')
            $aResult = getRiverToAjax($paPDO, $paSRID, $paPoint);
        else if ($functionname == 'getInfo')
             $aResult = getInfo($paPDO, $paSRID, $paPoint);
        else if ($functionname == 'getInfoFireStation')
            $aResult = getInfoFireStation($paPDO, $paSRID, $paPoint);
        else if ($functionname == 'getFireStation')
            $aResult = getFireStation($paPDO, $paSRID, $paPoint);
        else if ($functionname == 'getInfoDenver')
            $aResult = getInfoDenver($paPDO, $paSRID, $paPoint);
        else if ($functionname == 'getFoodStore')
            $aResult = getFoodStore($paPDO, $paSRID, $paPoint);
        else if ($functionname == 'getInfoFoodStore')
            $aResult = getInfoFoodStore($paPDO, $paSRID, $paPoint);
        else if ($functionname == 'getWhereFoodStore')
            $aResult = getWhereFoodStore($paPDO);
        else if ($functionname == 'getWhereInfoFoodStore')
            $aResult = getWhereInfoFoodStore($paPDO, $paSRID, $paPoint);
        else if ($functionname == 'getTree')
            $aResult = getTree($paPDO, $paTree);


        echo $aResult;
    
        closeDB($paPDO);
    }

    function initDB()
    {
        // Kết nối CSDL
        $paPDO = new PDO('pgsql:host=localhost;dbname=denver;port=5432', 'postgres', 'nguyen9414');
        return $paPDO;
    }
    function query($paPDO, $paSQLStr)
    {
        try
        {
            // Khai báo exception
            $paPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Sử đụng Prepare 
            $stmt = $paPDO->prepare($paSQLStr);
            // Thực thi câu truy vấn
            $stmt->execute();
            
            // Khai báo fetch kiểu mảng kết hợp
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            
            // Lấy danh sách kết quả
            $paResult = $stmt->fetchAll();   
            return $paResult;                 
        }
        catch(PDOException $e) {
            echo "Thất bại, Lỗi: " . $e->getMessage();
            return null;
        }       
    }
    function closeDB($paPDO)
    {
        // Ngắt kết nối
        $paPDO = null;
    }

    function getGeoCMRToAjax($paPDO,$paSRID,$paPoint)
    {
        //echo $paPoint;
        //echo "<br>";
        $paPoint = str_replace(',', ' ', $paPoint);
        //echo $paPoint;
        //echo "<br>";
        //$mySQLStr = "SELECT ST_AsGeoJson(geom) as geo from \"CMR_adm1\" where ST_Within('SRID=4326;POINT(12 5)'::geometry,geom)";

        // states
        $mySQLStr = "SELECT ST_AsGeoJson(geom) as geo from \"neighborhood\"  where ST_Within('SRID=".$paSRID.";".$paPoint."'::geometry,geom)";

        //Road
        
        //echo $mySQLStr;
        //echo "<br><br>";
        $result = query($paPDO, $mySQLStr);
        
        if ($result != null)
        {
            // Lặp kết quả
            foreach ($result as $item){
                return $item['geo'];
            }
        }
        else
            return "null";
    }

function getInfoDenver($paPDO, $paSRID, $paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
    $strDistance = "ST_Distance('" . $paPoint . "',ST_AsText(n.geom))";
    $strMinDistance = "SELECT min(ST_Distance('" . $paPoint . "',ST_AsText(geom))) from neighborhood";

    $mySQLStr = "SELECT nbrhd_name, population, count(nbrhd_name) as store, population/count(nbrhd_name) as pplperstore
    from neighborhood as n,food_location as f
    where " . $strDistance . " = (" . $strMinDistance . ") and " . $strDistance . " < 0.005 
    and ST_WITHIN(f.geom, n.geom)
group by n.nbrhd_name,n.population
order by pplperstore desc limit 1";

    

    $result = query($paPDO, $mySQLStr);

    if ($result != null) {
        $resFin = '<table>';
        // Lặp kết quả
        foreach ($result as $item) {
            $resFin = $resFin . '<tr><td>Hạt: ' . $item['nbrhd_name'] . '</td></tr>';
            $resFin = $resFin . '<tr><td>Số Cửa Hàng hiện có: ' . $item['store'] . '</td></tr>';
            $resFin = $resFin . '<tr><td>Dân số: ' . $item['population'] . '</td></tr>';
            $resFin = $resFin . '<tr><td>Số Dân / Số cửa hàng: ' . $item['pplperstore'] . '</td></tr>';
            break;
        }
        $resFin = $resFin . '</table>';
        return $resFin;
    } else
        return "null";
}



function getRiverToAjax($paPDO, $paSRID, $paPoint)
{
   
    $paPoint = str_replace(',', ' ', $paPoint);
    
    $strDistance = "ST_Distance('" . $paPoint . "',ST_AsText(geom))";
    $strMinDistance = "SELECT min(ST_Distance('" . $paPoint . "',ST_AsText(geom))) from street_routes";
    $mySQLStr = "SELECT ST_AsGeoJson(geom) as geo from street_routes 
    where " . $strDistance . " = (" . $strMinDistance . ") and " . $strDistance . " < 0.005";

//     $mySQLStr = "select st_asgeojson(geom) as geo from street_routes
// group by geom
// having st_distance('" . $paPoint."'::geometry::geography, geom) = min(st_distance('".$paPoint."'::geometry::geography, geom))
// and st_distance('".$paPoint."'::geometry::geography, geom) < 0.05";

    $result = query($paPDO, $mySQLStr);

    if ($result != null) {
        // Lặp kết quả
        foreach ($result as $item) {
            return $item['geo'];
        }
    } else
        return "null";
}

function getInfo($paPDO, $paSRID, $paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
    $strDistance = "ST_Distance('" . $paPoint . "',ST_AsText(geom))";
    $strMinDistance = "SELECT min(ST_Distance('" . $paPoint . "',ST_AsText(geom))) from street_centerline";
    $mySQLStr = "SELECT fullname, st_length(geom::geography) as length  from street_centerline where " . $strDistance . " = (" . $strMinDistance . ") and " . $strDistance . " < 0.005";
    $result = query($paPDO, $mySQLStr);

    if ($result != null) {
        $resFin = '<table>';
        // Lặp kết quả
        foreach ($result as $item) {
            $resFin = $resFin . '<tr><td>Tên Duong: ' . $item['fullname'] . '</td></tr>';
            $resFin = $resFin . '<tr><td>Chiều dài: ' . $item['length'] . '(met)</td></tr>';
            break;
        }
        $resFin = $resFin . '</table>';
        return $resFin;
    } else
        return "null";
}

function getInfoFireStation($paPDO, $paSRID, $paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
    $strDistance = "ST_Distance('" . $paPoint . "',ST_AsText(geom))";
    $strMinDistance = "SELECT min(ST_Distance('" . $paPoint . "',ST_AsText(geom))) from fire_stations";
    $mySQLStr = "SELECT full_addre, emergency_  from fire_stations where " . $strDistance . " = (" . $strMinDistance . ") and " . $strDistance . " < 0.001";
    $result = query($paPDO, $mySQLStr);

    if ($result != null) {
        $resFin = '<table>';
        // Lặp kết quả
        foreach ($result as $item) {
            $resFin = $resFin . '<tr><td>Dia chi: ' . $item['full_addre'] . '</td></tr>';
            $resFin = $resFin . '<tr><td>So Dien Thoai: ' . $item['emergency_'] . '</td></tr>';
            break;
        }
        $resFin = $resFin . '</table>';
        return $resFin;
    } else
        return "null";
}

function getFireStation($paPDO, $paSRID, $paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
    $strDistance = "ST_Distance('" . $paPoint . "',ST_AsText(geom))";
    $strMinDistance = "SELECT min(ST_Distance('" . $paPoint . "',ST_AsText(geom))) from fire_stations";
    $mySQLStr = "SELECT ST_AsGeoJson(geom) as geo  from fire_stations where " . $strDistance . " = (" . $strMinDistance . ") and " . $strDistance . " < 0.001";
    $result = query($paPDO, $mySQLStr);

        if ($result != null)
        {
            // Lặp kết quả
            foreach ($result as $item){
                return $item['geo'];
            }
        } else
        return "null";
}
function getInfoFoodStore($paPDO, $paSRID, $paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
    $strDistance = "ST_Distance('" . $paPoint . "',ST_AsText(geom))";
    $strMinDistance = "SELECT min(ST_Distance('" . $paPoint . "',ST_AsText(geom))) from food_location";
    $mySQLStr = "SELECT store_name, address_li, store_type  from food_location where " . $strDistance . " = (" . $strMinDistance . ") and " . $strDistance . " < 0.001";
    $result = query($paPDO, $mySQLStr);

    if ($result != null) {
        $resFin = '<table>';
        // Lặp kết quả
        foreach ($result as $item) {
            $resFin = $resFin . '<tr><td>Ten: ' . $item['store_name'] . '</td></tr>';
            $resFin = $resFin . '<tr><td>So Dia Chi: ' . $item['address_li'] . '</td></tr>';
            $resFin = $resFin . '<tr><td>Cua Hang: ' . $item['store_type'] . '</td></tr>';

            break;
        }
        $resFin = $resFin . '</table>';
        return $resFin;
    } else
        return "null";
}

function getFoodStore($paPDO, $paSRID, $paPoint){
        $paPoint = str_replace(',', ' ', $paPoint);
    $strDistance = "ST_Distance('" . $paPoint . "',ST_AsText(geom))";
    $strMinDistance = "SELECT min(ST_Distance('" . $paPoint . "',ST_AsText(geom))) from food_location";
    $mySQLStr = "SELECT ST_AsGeoJson(geom) as geo  from food_location where " . $strDistance . " = (" . $strMinDistance . ") and " . $strDistance . " < 0.001";
    $result = query($paPDO, $mySQLStr);

        if ($result != null)
        {
            // Lặp kết quả
            foreach ($result as $item){
                return $item['geo'];
            }
        } else
        return "null";
}

function getWhereInfoFoodStore($paPDO){
       
    $query = "select n.nbrhd_name, n.population,count(nbrhd_name) as store ,n.population/count(nbrhd_name) as pplperstore
from neighborhood as n, food_location as f
where ST_WITHIN(f.geom, n.geom)
group by n.nbrhd_name,n.population
order by pplperstore desc limit 1";
    $result = query($paPDO, $query);

    if ($result != null) {
        $resFin = '<table>';
        // Lặp kết quả
        foreach ($result as $item) {
            $resFin = $resFin . '<tr><td>Tên: ' . $item['nbrhd_name'] . '</td></tr>';
            $resFin = $resFin . '<tr><td>Số Cửa Hàng hiện có: ' . $item['store'] . '</td></tr>';
            $resFin = $resFin . '<tr><td>Dân số: ' . $item['population'] . '</td></tr>';
            $resFin = $resFin . '<tr><td>Số Dân / Số cửa hàng: ' . $item['pplperstore'] . '</td></tr>';

            break;
        }
        $resFin = $resFin . '</table>';
        return $resFin;
    } else
        return "null";
}

function getWhereFoodStore($paPDO){

    $query = "select ST_AsGeoJson(n.geom) as geo, n.population/count(nbrhd_name) as pplperstore
from neighborhood as n, food_location as f
where ST_WITHIN(f.geom, n.geom)
group by n.geom,n.population
order by pplperstore desc limit 1";
    $result = query($paPDO, $query);

        if ($result != null)
        {
            // Lặp kết quả
            foreach ($result as $item){
                return $item['geo'];
            }
        } else
        return "null";
}

function getTree($paPDO, $paTree){

     $query = "select st_asgeojson(geom) as geo from tree_inventory where inventory_ like '%". $paTree ."%' limit 3000";
    $result = query($paPDO, $query);
    
    //var_dump($result);
    //echo  json_encode($result);
    //error_reporting(0);
    $options = array(); 
            foreach ($result as $row){
                //array_push($options, $row['geo']);
                $options[] = $row;
            
            }
            //print_r($options[0]);
            //echo $options;
            //var_dump($options);
            return json_encode($options);
            //return ($options) ;

            // for($i=0;$i<10;$i++){
            //     return $options[];
            // }
            
            //return ($options);

            // return array(
            //     'geo' => $options
            // );
            //echo json_encode($results);
}
// function getCountTree($paPDO, $paTree){

//     $query = "select st_asgeojson(geom) from tree_inventory where inventory_ like '%". $paTree ."%'";
//     $result = query($paPDO, $query);

//         if ($result != null)
//         {
//             // Lặp kết quả
//             foreach ($result as $item){
//                 return $item['geo'];
//             }
//         } else
//         return "null";
// }

?>