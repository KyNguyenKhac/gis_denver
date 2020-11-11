<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>OpenStreetMap &amp; OpenLayers - Marker Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css" />
        <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
        
        <!-- <link rel="stylesheet" href="http://localhost:8081/libs/openlayers/css/ol.css" type="text/css" /> -->
        <!-- <script src="http://localhost:8081/libs/openlayers/build/ol.js" type="text/javascript"></script> -->
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" type="text/javascript"></script>
        
        <!-- <script src="http://localhost:8081/libs/jquery/jquery-3.4.1.min.js" type="text/javascript"></script> -->
        <style>
            
        .ol-popup {
            position: absolute;
            background-color: white;
            -webkit-filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
            filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.2));
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #cccccc;
            bottom: 12px;
            left: -50px;
            min-width: 180px;
        }

        .ol-popup:after,
        .ol-popup:before {
            top: 100%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .ol-popup:after {
            border-top-color: white;
            border-width: 10px;
            left: 48px;
            margin-left: -10px;
        }

        .ol-popup:before {
            border-top-color: #cccccc;
            border-width: 11px;
            left: 48px;
            margin-left: -11px;
        }

        .ol-popup-closer {
            text-decoration: none;
            position: absolute;
            top: 2px;
            right: 8px;
        }

        .ol-popup-closer:after {
            content: "✖";
        }

        #contain{
            background: white;
            position: absolute;
            bottom: 80%;
            left: 90%; 
            padding: 8px;
            border-radius: 6px;
            z-index: 1001;
        }

        #contain2{
            background: white;
            position: absolute;
            bottom: 5%;
            left: 80%;
            padding: 8px;
            border-radius: 6px;
            z-index: 1001;
        }

        .container{
            background: white;
            position: absolute;
            width: 10%;
            bottom: 80%;
            left: 10px;
            padding: 8px;
            
            border-radius: 6px;
            z-index: 1001;   
        }
        #btnRest{
            border-radius: 8px;
        }
        </style>
    </head>
    <body onload="initialize_map();">

        <div class="bigdiv">
                    <div id="map" style="width: 100%; height: 100%, position:absolute;top: 0;left: 0;z-index: -1"></div>
                <div id="popup" class="ol-popup">
                    <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                    <div id="popup-content"></div>
                </div>
<!-- Default unchecked -->
            <div  id="contain">
                <input onclick="oncheckfoodstore();" type="checkbox" id="food_store" name="layer" value="food_store"> food_stores <br />
                <input onclick="oncheckfirestations();" type="checkbox" id="fire_stations" name="layer" value="fire_stations"> fire_stations<br />
                <input onclick="oncheckroutes();" type="checkbox" id="routes" name="layer" value="routes"> routes <br />
                <input onclick="oncheckdenver()" type="checkbox" id="denver" name="layer" value="denver"> denver<br />
                <button id="btnRest"> Reset</button>
               
            </div>

    <div class="container">
        <!-- <div>Some Tree</div> -->
      <!--   <hr> -->
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <input onclick="oncheck2014()" type="checkbox" id="tree2014" name="layer" value="2014"> 2014<br />
                <input onclick="oncheck2015()" type="checkbox" id="tree2015" name="layer" value="2015"> 2015<br />
                <input onclick="oncheck2016()" type="checkbox" id="tree2016" name="layer" value="2016"> 2016<br />
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <input onclick="oncheck2017()" type="checkbox" id="tree2017" name="layer" value="2017"> 2017<br />
                <input onclick="oncheck2018()" type="checkbox" id="tree2018" name="layer" value="2018"> 2018<br />
                <input onclick="oncheck2019()" type="checkbox" id="tree2019" name="layer" value="2019"> 2019<br />
            </div>
        </div>
    </div>

       
            <div id='contain2'>
                <input onclick="oncheckwhere();" type="checkbox" id="where_food_store" name="layer" value="where_food_store"> Where should i open store in Denver? <br />
                               
            </div>

        </div>




        <script>
            var format = 'image/png';
        var container = document.getElementById('popup');
        var content = document.getElementById('popup-content');
        var closer = document.getElementById('popup-closer');
        var value;
        var overlay = new ol.Overlay( /** @type {olx.OverlayOptions} */ ({
            element: container,
            autoPan: true,
            autoPanAnimation: {
                duration: 250
            }
        }));
        closer.onclick = function() {
            overlay.setPosition(undefined);
            closer.blur();
            return false;
        };
        function handleOnCheck(id, layer) {
            if (document.getElementById(id).checked) {
                value = document.getElementById(id).value;
                // map.setLayerGroup(new ol.layer.Group())
                map.addLayer(layer)
                vectorLayer = new ol.layer.Vector({});
                map.addLayer(vectorLayer);
            } else {
                map.removeLayer(layer);
                map.removeLayer(vectorLayer);
            }
        }
                

        function oncheckfirestations() {
            handleOnCheck('fire_stations', fire_stations);

        }
        function oncheckroutes() {
            handleOnCheck('routes', denver_routes);

        }
        function oncheckdenver() {
            handleOnCheck('denver', denver);
        }
        function oncheckfoodstore() {
            handleOnCheck('food_store', food_store);
        }  

                function drawGeoJsonObj(paObjJson) {
                    var vectorSource = new ol.source.Vector({
                        features: (new ol.format.GeoJSON()).readFeatures(paObjJson, {
                            dataProjection: 'EPSG:4326',
                            featureProjection: 'EPSG:3857',
                        })
                    });
                    var vectorLayer = new ol.layer.Vector({
                        source: vectorSource
                    });
                 
                        map.addLayer(vectorLayer);
                }

                function drawGeoJsonObj2(paObjJson) {

                     // var fill = new ol.style.Fill({
                     //   color: 'rgba(255,255,255,0.4)'
                     // });
                     // var stroke = new ol.style.Stroke({
                     //   color: '#3399CC',
                     //   width: 1.25
                     // });                 

                
                     var icon = new ol.style.Icon({
                              //anchor: [0.5, 0.5],
                              //size: [52, 52],
                              //offset: [52, 0],
                              //opacity: 0.5,
                              //scale: 1.0,
                              src: "./testtree.png",
                     });
                    
                     var style = new ol.style.Style({
                         image: icon,  // this works, but when I use image: icon, nothing is displayed
                         // fill: fill,
                         // stroke: stroke
                       });  


                    var vectorSource = new ol.source.Vector({
                       
                        features: (new ol.format.GeoJSON()).readFeatures(paObjJson, {
                            dataProjection: 'EPSG:4326',
                            featureProjection: 'EPSG:3857',
                        })
                    });
                    var vectorLayer = new ol.layer.Vector({
                        source: vectorSource,
                        style: style,
                    });
                 
                        map.addLayer(vectorLayer);
                } 

                // function drawGeoJson2(geojson){
                //     var features = (new ol.format.GeoJSON()).readFeatures(geojson);

                //     features.forEach(function(feature){
                //         feature.setId(undefined);
                //         feature.getGeometry().transform('EPSG:4326', 'EPSG:3857');
                //     });
                // }

            function displayObjInfo2(result, coordinate) {
                $("#popup-content").html(result);
                overlay.setPosition(coordinate);

            }



        function oncheckwhere() {
                    $.ajax({
                        type: "POST",
                        url: "backend.php",
                        //dataType: 'json',
                        data: {functionname: 'getWhereFoodStore'},
                        success : function (result, status, erro) {

                            drawGeoJsonObj(result);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });

        } 

        function oncheck2014(){
            oncheck("tree2014");
        }
        function oncheck2015(){
            oncheck("tree2015");
        }
        function oncheck2016(){
            oncheck("tree2016");
        }
        function oncheck2017(){
            oncheck("tree2017");
        }
        function oncheck2018(){
            oncheck("tree2018");
        }
        function oncheck2019(){
            oncheck("tree2019");
        }

        function oncheck(id){

             treeTime = document.getElementById(id).value
            

                    $.ajax({
                        type: "POST",
                        url: "backend.php",
                        //dataType: 'json',
                        data: {functionname: 'getTree', paTreeTime: treeTime},
                        success : function (result, status, erro) {

                            //alert(JSON.parse(result));
                             test=  JSON.parse(result);

                             // check = test[0];
                             // alert(check['geo']);
                             for (var i = 0; i < test.length; i++) {
                                 drawGeoJsonObj2(test[i]['geo']);
                             }
                            //drawGeoJsonObj(result);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });            
        }

            function initialize_map() {
                //*
                layerBG = new ol.layer.Tile({
                    source: new ol.source.OSM({})
                });

            food_store = new ol.layer.Image({
                source: new ol.source.ImageWMS({
                    ratio: 1,
                    url: 'http://localhost:8081/geoserver/test/wms',
                    params: {
                        'FORMAT': format,
                        'VERSION': '1.1.1',
                        STYLES: '',
                        LAYERS: 'food_location',
                    }
                })

            });


            fire_stations = new ol.layer.Image({
                source: new ol.source.ImageWMS({
                    ratio: 1,
                    url: 'http://localhost:8081/geoserver/test/wms',
                    params: {
                        'FORMAT': format,
                        'VERSION': '1.1.1',
                        STYLES: '',
                        LAYERS: 'fire_stations2',
                    }
                })

            });

            denver_routes = new ol.layer.Image({
                source: new ol.source.ImageWMS({
                    ratio: 1,
                    url: 'http://localhost:8081/geoserver/test/wms',
                    params: {
                        'FORMAT': format,
                        'VERSION': '1.1.1',
                        STYLES: '',
                        LAYERS: 'street_routes',
                    }
                })

            });

            denver = new ol.layer.Image({
                source: new ol.source.ImageWMS({
                    ratio: 1,
                    url: 'http://localhost:8081/geoserver/test/wms',
                    params: {
                        'FORMAT': format,
                        'VERSION': '1.1.1',
                        STYLES: '',
                        LAYERS: 'neighborhood',
                    },
                    
                })

            });



                var viewMap = new ol.View({
                    center: ol.proj.fromLonLat([-105.05273451935501 ,39.76741901927694]),
                    zoom: 10
                    //projection: projection
                });

                map = new ol.Map({
                    target: "map",
                     layers: [layerBG],
                    view: viewMap,
                     overlays: [overlay], 
                });
                //map.getView().fit(bounds, map.getSize());
                
                var styles = {
                    'MultiLineString': new ol.style.Style({
                        fill: new ol.style.Fill({
                            color: 'rgba(235, 20, 5, 0.8)'
                        }),
                        stroke: new ol.style.Stroke({
                            color: 'rgba(235, 20, 5)',
                            width: 5
                        })
                    }),
                    'Point': new ol.style.Style({
                          image: new ol.style.Circle({
                            radius: 7,
                            fill: new ol.style.Fill({color: 'black'}),
                            stroke: new ol.style.Stroke({
                              color: [255,0,0], width: 2
                            })
                          })                        
                    }),
                    'MultiPolygon': new ol.style.Style({
                        fill: new ol.style.Fill({
                            color: 'rgba(201, 24, 45)'
                        }),
                        stroke: new ol.style.Stroke({
                            color: 'black',
                            width: 2
                        })
                    }),                    

                };

                 // var icon = new ol.style.Icon({
                 //          anchor: [0.5, 0.5],
                 //          size: [52, 52],
                 //          offset: [52, 0],
                 //          opacity: 0.5,
                 //          scale: 1.0,
                 //          src: "./img/mmOrange.png"
                 // });

                 // var style = new ol.style.Style({
                 //     image: icon,  // this works, but when I use image: icon, nothing is displayed
                 //     fill: fill,
                 //     stroke: stroke
                 //   });  

                var styleFunction = function (feature) {
                    return styles[feature.getGeometry().getType()];
                };
                var vectorLayer = new ol.layer.Vector({
                    //source: vectorSource,
                    style: styleFunction
                });
                vectorLayer.setZIndex(1000);
                map.addLayer(vectorLayer);

            var buttonReset = document.getElementById("btnRest").addEventListener("click", () => {
                location.reload();
            })

                function createJsonObj(result) {                    
                    var geojsonObject = '{'
                            + '"type": "FeatureCollection",'
                            + '"crs": {'
                                + '"type": "name",'
                                + '"properties": {'
                                    + '"name": "EPSG:4326"'
                                + '}'
                            + '},'
                            + '"features": [{'
                                + '"type": "Feature",'
                                + '"geometry": ' + result
                            + '}]'
                        + '}';
                    return geojsonObject;
                }


                function highLightGeoJsonObj(paObjJson) {
                    var vectorSource = new ol.source.Vector({
                        features: (new ol.format.GeoJSON()).readFeatures(paObjJson, {
                            dataProjection: 'EPSG:4326',
                            featureProjection: 'EPSG:3857'
                        })
                    });
					vectorLayer.setSource(vectorSource);


                }
                function highLightObj(result) {
                   
                    var strObjJson = createJsonObj(result);
                   
                    var objJson = JSON.parse(strObjJson);
                
                    highLightGeoJsonObj(objJson);
                }
            function displayObjInfo(result, coordinate) {
                $("#popup-content").html(result);
                overlay.setPosition(coordinate);

            }


                map.on('singleclick', function (evt) {
                
                   
                    var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
                    var lon = lonlat[0];
                    var lat = lonlat[1];
                    var myPoint = 'POINT(' + lon + ' ' + lat + ')';
                    
                    //*
                if(value == 'denver'){
                    $.ajax({
                        type: "POST",
                        url: "backend.php",
                        //dataType: 'json',
                        data: {functionname: 'getGeoCMRToAjax', paPoint: myPoint},
                        success : function (result, status, erro) {
                            highLightObj(result);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "backend.php",
                        //dataType: 'json',
                        data: {functionname: 'getInfoDenver', paPoint: myPoint},
                        success : function (result, status, erro) {
                            displayObjInfo(result, evt.coordinate);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });                   
                 }
                 if(value == 'routes'){


                    $.ajax({
                        type: "POST",
                        url: "backend.php",
                        //dataType: 'json',
                        data: {functionname: 'getRiverToAjax', paPoint: myPoint},
                        success : function (result, status, erro) {
                            highLightObj(result);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "backend.php",
                        //dataType: 'json',
                        data: {functionname: 'getInfo', paPoint: myPoint},
                        success : function (result, status, erro) {
                              displayObjInfo(result, evt.coordinate);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });   
                }
                if(value == 'fire_stations'){
                    $.ajax({
                        type: "POST",
                        url: "backend.php",
                        //dataType: 'json',
                        data: {functionname: 'getFireStation', paPoint: myPoint},
                        success : function (result, status, erro) {
                            highLightObj(result);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "backend.php",
                        //dataType: 'json',
                        data: {functionname: 'getInfoFireStation', paPoint: myPoint},
                        success : function (result, status, erro) {
                              displayObjInfo(result, evt.coordinate);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });
                }
               if(value == 'food_store'){
                    $.ajax({
                        type: "POST",
                        url: "backend.php",
                        //dataType: 'json',
                        data: {functionname: 'getFoodStore', paPoint: myPoint},
                        success : function (result, status, erro) {
                            highLightObj(result);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "backend.php",
                        //dataType: 'json',
                        data: {functionname: 'getInfoFoodStore', paPoint: myPoint},
                        success : function (result, status, erro) {
                              displayObjInfo(result, evt.coordinate);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });
                }
                if(value == 'where_food_store'){
                    $.ajax({
                        type: "POST",
                        url: "backend.php",
                        //dataType: 'json',
                        data: {functionname: 'getWhereInfoFoodStore'},
                        success : function (result, status, erro) {
                              displayObjInfo(result, evt.coordinate);
                        },
                        error: function (req, status, error) {
                            alert(req + " " + status + " " + error);
                        }
                    });                    
                }  


                });
            };
        </script>
    </body>
</html>