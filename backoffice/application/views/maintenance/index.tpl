<!DOCTYPE html>
<html>
<head>
    <title>{$title}</title>
</head>
<body>
    <div class="main-login col-sm-4 col-sm-offset-4">
        <div class="logo" style="text-align: center;">
            <img src="{$PUBLIC_URL}images/logos/logo.png"/>
        </div>
        <!-- start: LOGIN BOX -->
        <div class="box-login">    
            <div id="profileTabData" class="both" style="text-align: center;">
                <h3>{$MAINTENANCE_DATA['title']}</h3>
                <p>{$MAINTENANCE_DATA['description']}</p>
                {if $MAINTENANCE_DATA['date_of_availability']}
                    <p>The site will be available on {$MAINTENANCE_DATA['date_of_availability']}</p>
                {/if}
            </div>
        </div>
    </div>
</body>
</html>