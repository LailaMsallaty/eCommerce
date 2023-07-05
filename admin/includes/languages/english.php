<?php 


    function lang ($phrase)

    {
   
        static $lang = Array(     // static not dynamic So it is not called more than once

           // HomePage

          

          'HOME_ADMIN' => 'Dashboard',
           
          'CATEGORIES' => 'Categories',

          'ITEMS'      => 'Items',

          'MEMBERS'    => 'Members',

          'COMMENTS'   => 'Comments' ,

          'STATISTICS' => 'Statistics',

          'LOGS'       => 'Logs' ,

          'REPORTS'   => 'Reports' ,
          
          'CARDS'   => 'Cards' ,





           // settings

        );

        return $lang[$phrase];



    }