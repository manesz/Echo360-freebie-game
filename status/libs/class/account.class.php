<?php
if(!class_exists('connectionClass')){ include_once('connection.class.php'); };


class accountClass {

    private $connClass;

    public function __construct(){
        $this->connClass = new connectionClass();
    }

    public function getProfileInfo($profileId){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getInterActProfileInfo]('$profileId')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);

        return $result;
    }//END: getProfileInfo()

    // get "Age" with parameter ----------------------------------------------------------------------------------------
    public function getDailyPortfolio($data, $condition = null, $option = null){

        $resultData = '['.$data.']';
        $resultCondition = '';
        foreach($condition as $key=>$value){
            $resultCondition.="'".$value."',";
        };
        $resultCondition = substr($resultCondition, 0, -1);

        if(!empty($option)){ $option = "and ".$option; } else { $option = ''; };

        if(!empty($condition)){ $sqlWhere = "WHERE [Status_Cd] IN(".$resultCondition.") ".$option; } else { $sqlWhere = ''; };
        if(!empty($resultData)){ $sqlGroupby = "GROUP BY $resultData"; } else { $sqlGroupby = ''; };
        if(!empty($resultData)){ $sqlOrderby = "ORDER BY $resultData"; } else { $sqlOrderby = ''; };

        $sql = "
            SELECT $resultData, COUNT(*) as Total
            FROM(
            SELECT a.[Account_Id]
                  ,DATEPART(YEAR, GETDATE()) - a.[Year_Of_Birth] AS Age
                  ,a.[Gender_Cd] as Gender
                  ,a.[Status_Cd]
                  ,a.[Income_Range_Cd]
                  ,a.[Occupation_Cd]
                  ,a.[Education_Cd]
                  ,a.[Marital_Status_Cd]
                  ,a.[Children_Flag]
                  ,a.[User_Name] as Email
                  ,a.[First_Mobile_Number]
                  ,a.[Channel_Cd]
                  ,a.[Staff_No]
                  ,a.[Zipcode]
                  ,a.[Areacode]
                  ,SUBSTRING(a.[Zipcode], 1, 2) as Zip2Digit
                  ,case
                     when a.Zipcode is null then null
                     when b.location is null then 'UPC'
                     else b.location
                     end
                     as Location
                  ,d.province as [Province]
                  ,d.region as [Region]
                  ,c.TotalCall
                  ,Case
                       When c.TotalCall is null then 'NoUse'
                       when c.TotalCall > 0 and c.TotalCall < 15 then 'Low Activity'

                   end as Activity
                  ,a.[Registration_Dttm]
                  ,a.[Activation_Dttm]
                  ,a.[First_Call_Dttm]
                  ,a.[Created_By]
                  ,a.[Created_Dttm]
                  ,a.[Updated_By]
                  ,a.[Updated_Dttm]
              FROM [SUB-DB].[Echo].[dbo].[Account] a
              LEFT JOIN [DEV2].[RSS-DEV].[dbo].[rss_areacode_map_location] b ON CAST(SUBSTRING(a.[Zipcode], 1, 2) as int) = CAST(b.[areacode] as int)
              LEFT OUTER JOIN (
                  SELECT [Account_Id]
                      ,SUM([N_Call_In]) as TotalCall
                  FROM [RSS-DEV].[dbo].[call_log_daily_summary]
                  Where CallDate > getdate() - 16
                  Group by Account_Id
              ) c on a.Account_Id = c.Account_Id
              LEFT OUTER JOIN(
                  SELECT [province]
                      ,[location]
                      ,[priority]
                      ,[status]
                      ,[postcode2digit]
                      ,[region]
                      ,[ban]
                  FROM [RSS-DEV].[dbo].[rss_postcode_province]
              ) d on SUBSTRING(a.[Zipcode], 1, 2) = d.[postcode2digit]
            ) a
            ".$sqlWhere." ".$sqlGroupby." ".$sqlOrderby;
//        echo $sql.'<br/>';exit();
        $conn = $this->connClass->sqlsrv_connection();
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $sum = 0;
        while( $result = sqlsrv_fetch_array($query) ){
            $sum = $sum+$result[1];
//            if(is_null($result[0])): $result[0]=''; else: $result[0]=$result[0]; endif;
//            if(is_null($result[1])): $result[1]=''; else: $result[1]=$result[1]; endif;
            $arrResult[] = array($result[0], $result[1], $sum);
        }
        return $arrResult;

    }

    public function getDailyPortfolioAcAcdAgeList(){

        $getDailyPortfolioLess15 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age < 15');
        $getDailyPortfolio18 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 15 AND 18');
        $getDailyPortfolio24 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 19 AND 24');
        $getDailyPortfolio29 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 25 AND 29');
        $getDailyPortfolio34 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 30 AND 34');
        $getDailyPortfolio45 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 35 AND 45');
        $getDailyPortfolio50 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 46 AND 50');
        $getDailyPortfolioMore50 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age > 50');

        $resultgetDailyPortfolioSort  = array(
            array('less 15', end($getDailyPortfolioLess15[count($getDailyPortfolioLess15)-1])),
            array('15 - 18', end($getDailyPortfolio18[count($getDailyPortfolio18)-1])),
            array('19 - 24', end($getDailyPortfolio24[count($getDailyPortfolio24)-1])),
            array('25 - 29', end($getDailyPortfolio29[count($getDailyPortfolio29)-1])),
            array('30 - 34', end($getDailyPortfolio34[count($getDailyPortfolio34)-1])),
            array('35 - 45', end($getDailyPortfolio45[count($getDailyPortfolio45)-1])),
            array('46 - 50', end($getDailyPortfolio50[count($getDailyPortfolio50)-1])),
            array('More 50', end($getDailyPortfolioMore50[count($getDailyPortfolioMore50)-1]))
        );

        return $resultgetDailyPortfolioSort;

    }//END: getDailyPortfolioList()

    public function getDailyPortfolioAgeList(){

        $getDailyPortfolioAcAcdLess15 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age < 15');
        $getDailyPortfolioAcAcd18 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 15 AND 18');
        $getDailyPortfolioAcAcd24 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 19 AND 24');
        $getDailyPortfolioAcAcd29 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 25 AND 29');
        $getDailyPortfolioAcAcd34 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 30 AND 34');
        $getDailyPortfolioAcAcd45 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 35 AND 45');
        $getDailyPortfolioAcAcd50 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age BETWEEN 46 AND 50');
        $getDailyPortfolioAcAcdMore50 = $this->getDailyPortfolio('Age', array('AC', 'ACD'), 'Age > 50');

        $getDailyPortfolioAcLess15 = $this->getDailyPortfolio('Age', array('AC'), 'Age < 15');
        $getDailyPortfolioAc18 = $this->getDailyPortfolio('Age', array('AC'), 'Age BETWEEN 15 AND 18');
        $getDailyPortfolioAc24 = $this->getDailyPortfolio('Age', array('AC'), 'Age BETWEEN 19 AND 24');
        $getDailyPortfolioAc29 = $this->getDailyPortfolio('Age', array('AC'), 'Age BETWEEN 25 AND 29');
        $getDailyPortfolioAc34 = $this->getDailyPortfolio('Age', array('AC'), 'Age BETWEEN 30 AND 34');
        $getDailyPortfolioAc45 = $this->getDailyPortfolio('Age', array('AC'), 'Age BETWEEN 35 AND 45');
        $getDailyPortfolioAc50 = $this->getDailyPortfolio('Age', array('AC'), 'Age BETWEEN 46 AND 50');
        $getDailyPortfolioAcMore50 = $this->getDailyPortfolio('Age', array('AC'), 'Age > 50');

        $getDailyPortfolioApLess15 = $this->getDailyPortfolio('Age', array('AP'), 'Age < 15');
        $getDailyPortfolioAp18 = $this->getDailyPortfolio('Age', array('AP'), 'Age BETWEEN 15 AND 18');
        $getDailyPortfolioAp24 = $this->getDailyPortfolio('Age', array('AP'), 'Age BETWEEN 19 AND 24');
        $getDailyPortfolioAp29 = $this->getDailyPortfolio('Age', array('AP'), 'Age BETWEEN 25 AND 29');
        $getDailyPortfolioAp34 = $this->getDailyPortfolio('Age', array('AP'), 'Age BETWEEN 30 AND 34');
        $getDailyPortfolioAp45 = $this->getDailyPortfolio('Age', array('AP'), 'Age BETWEEN 35 AND 45');
        $getDailyPortfolioAp50 = $this->getDailyPortfolio('Age', array('AP'), 'Age BETWEEN 46 AND 50');
        $getDailyPortfolioApMore50 = $this->getDailyPortfolio('Age', array('AP'), 'Age > 50');

        $resultGetDailyPortfolioAcAcd  = array(
            array('less 15', end($getDailyPortfolioAcAcdLess15[count($getDailyPortfolioAcAcdLess15)-1])),
            array('15 - 18', end($getDailyPortfolioAcAcd18[count($getDailyPortfolioAcAcd18)-1])),
            array('19 - 24', end($getDailyPortfolioAcAcd24[count($getDailyPortfolioAcAcd24)-1])),
            array('25 - 29', end($getDailyPortfolioAcAcd29[count($getDailyPortfolioAcAcd29)-1])),
            array('30 - 34', end($getDailyPortfolioAcAcd34[count($getDailyPortfolioAcAcd34)-1])),
            array('35 - 45', end($getDailyPortfolioAcAcd45[count($getDailyPortfolioAcAcd45)-1])),
            array('46 - 50', end($getDailyPortfolioAcAcd50[count($getDailyPortfolioAcAcd50)-1])),
            array('More 50', end($getDailyPortfolioAcAcdMore50[count($getDailyPortfolioAcAcdMore50)-1]))
        );

        $resultGetDailyPortfolioAc  = array(
            array('less 15', end($getDailyPortfolioAcLess15[count($getDailyPortfolioAcLess15)-1])),
            array('15 - 18', end($getDailyPortfolioAc18[count($getDailyPortfolioAc18)-1])),
            array('19 - 24', end($getDailyPortfolioAc24[count($getDailyPortfolioAc24)-1])),
            array('25 - 29', end($getDailyPortfolioAc29[count($getDailyPortfolioAc29)-1])),
            array('30 - 34', end($getDailyPortfolioAc34[count($getDailyPortfolioAc34)-1])),
            array('35 - 45', end($getDailyPortfolioAc45[count($getDailyPortfolioAc45)-1])),
            array('46 - 50', end($getDailyPortfolioAc50[count($getDailyPortfolioAc50)-1])),
            array('More 50', end($getDailyPortfolioAcMore50[count($getDailyPortfolioAcMore50)-1]))
        );

        $resultGetDailyPortfolioAp  = array(
            array('less 15', end($getDailyPortfolioApLess15[count($getDailyPortfolioApLess15)-1])),
            array('15 - 18', end($getDailyPortfolioAp18[count($getDailyPortfolioAp18)-1])),
            array('19 - 24', end($getDailyPortfolioAp24[count($getDailyPortfolioAp24)-1])),
            array('25 - 29', end($getDailyPortfolioAp29[count($getDailyPortfolioAp29)-1])),
            array('30 - 34', end($getDailyPortfolioAp34[count($getDailyPortfolioAp34)-1])),
            array('35 - 45', end($getDailyPortfolioAp45[count($getDailyPortfolioAp45)-1])),
            array('46 - 50', end($getDailyPortfolioAp50[count($getDailyPortfolioAp50)-1])),
            array('More 50', end($getDailyPortfolioApMore50[count($getDailyPortfolioApMore50)-1]))
        );

        $result = array(
            $resultGetDailyPortfolioAcAcd,
            $resultGetDailyPortfolioAc,
            $resultGetDailyPortfolioAp
        );

        return $result;

    }//END: getDailyPortfolioList()

    public function getAccountStatusAll(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getAccountStatusAll](1)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ):
            $arrResult[] = array(
                $result[0]->format('Y-m-d') //datetime
                , $result[1] //status title
                , $result[2] // status value
            );
        endwhile;
        return $arrResult;
    }//END: getAccountStatus

    public function getAccountWithStatus($type, $status = null){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getAccountStatusAll]($type, '$status')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ):
            $arrResult[] = array(
                $result[0]->format('Y-m-d') //datetime
            , $result[1] //status title
            , $result[2] // status value
            );
        endwhile;
        return $arrResult;
    }//END: getAccountStatus

}