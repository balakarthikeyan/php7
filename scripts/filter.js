jQuery(document).ready(function ($) {

    //Using for loop
    function findObjectByKey(array, key, value) {
        var results = [];
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                results.push(array[i]);
            }
        }  
        return results;
    }
    console.log("Find Object By Key : ", findObjectByKey(customData, "category", "bal"))


    function customFilter(argData, argObj) {
        if (argData == undefined && argObj == undefined) {
            return false;
        }
        var matches = [];
        for (var key in argObj) {
            if (argObj.hasOwnProperty(key) && argObj[key] instanceof Object) {
                var objectArray = Object.entries(argObj[key]);
                objectArray.forEach(function ([rowindex, row], column, arr) {
                    var output = argData.filter(function (value, index, obj) {
                        var asObj = Object.prototype.toString.call(value[key]);
                        if (asObj === '[object Array]') {
                            return value[key] == row;
                        }                        
                        if (asObj === '[object Object]') {
                            for (dkey in value[key]) {
                                if (value[key].hasOwnProperty(dkey)) {
                                    return value[key][dkey] == row;
                                }
                            }
                        }                         
                    });
                    matches.push(output);
                });
            } else {
                var output = argData.filter(function (obj) {
                    return obj[key] == argObj[key];
                });
                matches.push(output);
            }
        }
        console.log("Final :", matches);
    }

    function customSingleFilter(argData, argObj) {
        //Get arguments length
        if (arguments.length > 0) {
            // console.log("Arguments length: ", arguments.length);
            var args = Array.prototype.slice.call(arguments, 0);
            // console.log(args);
        }
    
        //Validate arguments
        if (argData == undefined && argObj == undefined) {
            return false;
        }
    
        // Get the size & key pairs of an argument object
        var filterKeys = Object.keys(argObj);
        var filterVals = Object.values(argObj);
        var results = [];
        
        for (var x = 0; x < filterKeys.length; x++) {
            var filterKey = filterKeys[x];
            var filterValue = filterVals[x];
            var output = argData.filter(function (obj) {
                return obj[filterKey] == filterValue;
            });
            results.push(output);
        }
        console.log("Final :", results);
    }

    
    filteringObject = {
        category: "bal",
        regions: ["chest", "shoulders"],
        video: { en: "se_bal_003_en.mp4" },
    };    
    customFilter(customData, filteringObject);
    
    filteringObject = {category:'bal', regions:'shoulders', ID:'004'};
    customSingleFilter(customData, filteringObject);

});
