        $(document).ready(function() {
            createDropDown();
            
            $(".dropdown dt a").click(function() {
                $(".dropdown dd ul").toggle();
                $(".step3").fadeIn();
                return false;
            });

            $(document).bind('click', function(e) {
                var $clicked = $(e.target);
                if (! $clicked.parents().hasClass("dropdown"))
                    $(".dropdown dd ul").hide();
                    $(".step3").fadeOut();
            });
                        
            $(".dropdown dd ul li a").click(function() {
                var text = $(this).html();
                $(this).addClass('checked');
                $(".dropdown dt a").html(text);
                $(".dropdown dd ul").hide();
                var source = $("#source");
                $(".step3").fadeOut();
                source.val($(this).find("span.value").html())
                return false;
            });
            
            $('img').hide();

            function slider() {
                $(".signUp img:first").appendTo('.signUp').fadeOut(5000);
                $(".signUp img:first").fadeIn(5000);
                
                setTimeout(slider, 7000);
            }
            
            slider();
            
            // Start Tooltips
            
            $('input[name="fullName"]').focus(function() {
                $('.step1').fadeIn();
            });
            
            $('input[name="fullName"]').blur(function() {
                $('.step1').fadeOut();
            });
            
            $('input[name="usrMail"]').focus(function() {
                $('.step2').fadeIn();
            });
            
            $('input[name="usrMail"]').blur(function() {
                $('.step2').fadeOut();
            });
            
            $('input[name="fullName"]').focus();
            
            var algText = $('.algDrop .checked .value').text();
            
            var goodToContinue = 0,
                somethingSelected = 0;
            
            function checkForm() {
                
                if ( $('#target dt a .value').html() != '-1') {
                    somethingSelected = 1;
                } else {
                    somethingSelected = 0;
                }

                var email = $('.input_email').val();
                var fullName = $('.input_name').val();
                var fileName = "";
                if (document.getElementById('fileToUpload') !== null) fileName = document.getElementById('fileToUpload').value;
                if( (fullName != "" ) && (email != "" ) && (isEmail(email)) && (fileName !== "")) {
                   goodToContinue = 1;
                } else {
                   goodToContinue = 0;
                }
                
                if(goodToContinue == 1 && somethingSelected == 1) {
                    $('.continue').removeClass('grayed').addClass('blue-button');
                } else {
                    $('.continue').removeClass('blue-button').addClass('grayed');
                }
                
            }
            
            $(document).mousemove(function(event) {
                checkForm();
            });
            
            $(".signUp :input").change(function(event) {
                checkForm();
            });

            $(".signUp :input").keyup(function() {
                checkForm();
            });

            $('.continue').click(function(){
                if (!$(this).hasClass('grayed')) {
                    $('#kin_form').submit();
                }
            })
                
            
            loadLatestTweet();
            
            
            var file_name, file_end, file_page, claimed_forum_pages, claimed_member_pages;
    
            claimed_forum_pages = ["forumdisplay", "showthread", "private", "usercp", "modcp", "stats", "newthread", "newreply"];
            claimed_member_pages = ["member"]; 
                
            //Add pathname to html tag
            file_name = document.location.href;
            file_end = (file_name.indexOf("?") == -1) ? file_name.length : file_name.indexOf("?");
            file_page = file_name.substring(file_name.lastIndexOf("/")+1, file_end);
            file_page = file_page.replace('.php','').replace('#','');
                
            $('body').addClass("page_" + file_page);
            
            if (file_page == '/' || file_page === '') {
                file_page = "index";
            }
            
            if ($.inArray(file_page, claimed_forum_pages) >= 0) {
                $('.headLinks li').removeClass('active');
                $(".headLinks").find('a[href *="index.php"]').removeClass('inactive').addClass("active");
            } else if ($.inArray(file_page, claimed_member_pages) >= 0) {
                $('.headLinks li').removeClass('active');
                $(".headLinks").find('a[href *="memberlist.php"]').removeClass('inactive').addClass("active");
            } else {
                $('.headLinks li').removeClass('active');
                $(".headLinks").find('a[href *="' + file_page  + '.php"]').removeClass('inactive').addClass("active");
            }
            
            var focus = document.getElementById("contact_name");
            
            if (focus) {
                document.getElementById("contact_name").focus();
            }
            
        });
        
        function createDropDown(){
            var source = $("#source");
            var selected = source.find("option[selected]");  // get selected <option>
            var options = $("option", source);  // get all <option> elements
            // create <dl> and <dt> with selected value inside it
            $(".algDrop").append('<dl id="target" class="dropdown"></dl>')
            $("#target").append('<dt><a href="#">' + selected.text() + 
                '<span class="value">' + selected.val() + 
                '</span></a></dt>')
            $("#target").append('<dd><ul></ul></dd>')
            // iterate through all the <option> elements and create UL
            options.each(function(){
                
                $("#target dd ul").append('<li class="option_'+ $(this).val() +'"><a href="#">' + 
                    $(this).text() + '<span class="value">' + 
                    $(this).val() + '</span></a></li>');
            });
            source.hide();
        }

        function parseDate(str) {
            var v=str.split(' ');
            return new Date(Date.parse(v[1]+" "+v[2]+", "+v[5]+" "+v[3]+" UTC"));
        } 
         
        function loadLatestTweet(){
            $.getJSON("https://api.twitter.com/1/statuses/user_timeline/Audentio.json?count=1&include_rts=1&callback=?",function(data){
                var created = parseDate(data[0].created_at);
                var createdHours = created.getHours();
                var createdMinutes = created.getMinutes();
                if (createdHours > 0) {
                    $(".tweetHours").html(createdHours + " Hours Ago");
                } else {
                    $(".tweetHours").html(createdMinutes + " Minutes Ago");
                }
                $(".tweet").html(data[0].text);
            });
        }

        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
        
        function processTable(id){
            var table = $(id),
                ret = '',
                population = -1,
                nloci = 0;

            var rows = table.find('tr');
            for (var i = 0, len = rows.length; i < len; i++){
                var row = rows[i],
                    cells = $('td.highlighted', row),
                    line = '';
                for (var j = 0, len2 = cells.length; j < len2; j++){
                    if (line === ''){
                        line = cells[j].innerHTML;
                    } else {
                        line += ',' + cells[j].innerHTML.replace('/', ',');
                    }
                }

                if (line !== '') {
                    ret += line + '\n';
                    population++;
                    nloci = (cells.length - 1);
                }
            }

            $('#population').html(population);
            $('#nloci').html(nloci);

            $('#populationData').val(population);
            $('#nlociData').val(nloci);
            $('#tableData').val(ret);
        }
        