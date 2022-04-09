<b:includable id='mobile-header-home'>
    <div class="container-fluid whdr">        
        <nav class="main navn navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <div class="nv-menu">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <img class="icon menuclosed" src="https://i.imgur.com/uUfZvz5.png"/>
                        <img class="icon menuopened" src="https://i.imgur.com/WBiuVKu.png"/>                        
                    </button>
                </div>
                <div class="navbar-brand nv-logo">
                    <div class="input-group col-md-12">
                        <span class="_logoimg">
                            <a expr:href="data:blog.homepageUrl"><img class="logohm" src="https://i.imgur.com/pP2wLgu.png" alt="SabNews" title="SabNews"/></a>
                        </span>
                        <span class="input-group-btn sn-search">
                            <button id="viewsearch" class="searchicon f22 btn btn-info btn-default" type="button">
                                <i class="sni search"></i>
                            </button>
                        </span>
                    </div>
                </div>

                <div class="navbar-search hidden">
                    <form class="frmsearh" action="/search" method="get">
                        <div class="input-group col-md-12">
                            <input class="form-control input-md searchbx" name="q" type="text" id="search" placeholder="Search" required="required" />
                            <span class="input-group-btn">
                                <button id="searchbtn" class="searchicon f22 btn btn-info btn-default" type="submit">
                                    <i class="sni search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>                
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a expr:href='data:blog.homepageUrl + &quot;&quot;'>Home</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#entertainmentlist&quot;'>Entertainment</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#politicslist&quot;'>Politics</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#lifestylelist&quot;'>Life Style</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#educationlist&quot;'>Education</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#sportlist&quot;'>Sports</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#businesslist&quot;'>Business</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#technologylist&quot;'>Technology</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#adventurelist&quot;'>Adventure</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#sciencelist&quot;'>Science</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#healthlist&quot;'>Health</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#history&quot;'>History</a></li>
                    <li><a expr:href='data:blog.homepageUrl + &quot;#hollywood&quot;'>Hollywood</a></li>
                </ul>
            </div>
        </nav>
    </div>
</b:includable>