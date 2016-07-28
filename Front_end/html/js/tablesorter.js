$(document).ready(function() {
            
            function tableFilter(table) {
            
                var fields = $(table + " tbody td"),
                    values = $(table + " .highlighted");
                    
                function getSiblingNumber(oElement) {
                    return $(oElement).parent().children(oElement.nodeName).index(oElement);
                }
                    
                function tableInformation(outputLocation) {
                    $(outputLocation).empty();
                    var columnValues = $(table + ' tbody td.highlighted').map(function(i) {
                        return $(this).text();
                    });
                    
                    var columnNum = $(table + ' tbody tr:nth-child(2) .highlighted,' + table + ' tbody tr:nth-child(2).removed').length;
                    
                    var test = [];
                    for (var i = 0; i < columnValues.length; i++) {
                        if ( ((i + 1) % columnNum) === 0) {
                            test.push(columnValues[i] + ', <br>');
                        } else {
                            test.push(columnValues[i] + ', ');
                        }
                    }
                    
                    var newtest = test.join("");
                    
                    $(outputLocation).html(newtest);
                }
                
                fields.each(function() {
                    if (! $(this).find("input").length > 0 && ! $(this).is(':empty')) {
                        $(this).addClass('highlighted');
                    }
                });
                
                $(table + ' input:checkbox').on('change', function(){
                    var column = getSiblingNumber($(this).parent()) + 1;
                    if ($(this).is(':checked')){
                        if ($(this).parent().parent().is('.topRow')) {
                            $('tbody tr:not(".topRow") td:nth-child(' + column + ')').not(".sideRemoved, .sideHighlighted").addClass('highlighted topHighlight').removeClass('removed topRemoved');
                        } else {
                            $(this).parent().parent().children('td:not(:first-child)').not(".topRemoved, .topHighlighted").addClass('highlighted sideHighlight').removeClass('removed sideRemoved');
                        }
                    } else {
                        if ($(this).parent().parent().is('.topRow')) {
                            $('tbody tr:not(".topRow") td:nth-child(' + column + ')').not(".sideHighlighted, .sideRemoved").addClass('removed topRemoved').removeClass('highlighted topHighlight');
                        } else {
                            $(this).parent().parent().children('td:not(:first-child)').not(".topHighlighted, .topRemoved").addClass('removed sideRemoved').removeClass('highlighted sideHighlight');
                        }
                    }
                    
                    tableInformation('.values');
                    processTable(table);
                });
                
                $('.all_on').on('click', function() {
                    $(table + ' :checkbox').each(function() {
                        $(this).prop( "checked", true );
                    });
                    $(table + ' tbody .removed:not(.permanent)').addClass('highlighted').removeClass('removed');
                    tableInformation('.values');
                    processTable(table);
                    return false;
                });
                
                $('.all_off').on('click', function() {
                    $(table + ' :checkbox').each(function() {
                        $(this).prop( "checked", false )
                    });
                    $(table + ' tbody .highlighted:not(.permanent)').addClass('removed').removeClass('highlighted');
                    tableInformation('.values');
                    processTable(table);
                    return false;
                });
                
                tableInformation('.values');
                processTable(table);
            
            }
            
            tableFilter('#newtable');
            
        });