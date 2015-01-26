<?php
if(!class_exists('connectionClass')){ include_once('connection.class.php'); };


class offerClass {

    private $connClass;

    public function __construct(){
        $this->connClass = new connectionClass();
    }

    //-------------------------------------------------------------------------------------  Get Offer Information Set

    public function getTotalImp($startDate = null){
        $date = date($startDate);
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getTotalImp]('$date')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);
        return $result;
    }//END: getTotalImp()

    public function getTotalUR($startDate = null){
        $date = date($startDate);
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getTotalUR]('$date')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);
        return $result;
    }//END: getTotalUR()

    public function getOfferDisplay($startDate = null){
        $date = date($startDate);
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferDisplay]('$date')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $num = 0;
        while( $result = sqlsrv_fetch_array($query) ){
            $arrResult[] = array(
                $result[0] // contact date
                , $result[1] // offer name
            );
        }
        return $arrResult;
    }//END: getOfferDisplay()

    public function getOfferDayImpAll($startDate = null, $endDate = null){
        $date = date($startDate);
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferDayImpAll]('$date')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $num = 0;
        while( $result = sqlsrv_fetch_array($query) ){
            $num++;
            $arrResult[] = array("id"=>$num,"OfferCode"=>$result[0], "Name"=>$result[1], "Imp"=>$result[2], "date"=>$result[3]);
        }
        return $arrResult;
    }//END: getAllOfferImpToDay()

    public function getOfferHoursImpAll($startDate = null, $endDate = null){

        if(!empty($startDate)): $date = $startDate; else: $date = date('Y-m-d'); endif;
//        echo $date;exit();
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferImpressInHoursAll]('".$date."')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $num = 0;
        $sum = 0;
        while( $result = sqlsrv_fetch_array($query) ){
            $num++;
            $sum = $sum+$result[1];
            $arrResult[] = array("id"=>$num, "Times"=>$result[0], "Imp"=>$result[1], "Total"=>$sum);
        }
        return $arrResult;
    }//END: getAllOfferHoursImp

    public function getOfferHoursImp($offerCode, $startDate = null, $endDate = null){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferImpressInHours]($offerCode, '$startDate')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $num = 0;
        $sum = 0;
        while( $result = sqlsrv_fetch_array($query) ){
            $sum = $sum+$result[1];
            $num++;
            $arrResult[] = array("id"=>$num,"OfferCode"=>$offerCode, "Times"=>$result[0], "Imp"=>$result[1], "Total"=>$sum);
        }

        if(is_null(@$arrResult)): @$arrResult = array(); endif;

        return $arrResult;
    }//END: getOfferHoursImp()

    public function getOfferCompletionLate(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferCompletionRate]}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ){
            $arrResult[] = array(
                "offerCode"=>$result[0],
                "Name"=>$result[1],
                "Description"=>$result[2],
                "Type"=>$result[3],
                "Limit"=>$result[4],
                "Used"=>$result[5],
                "Rate"=>$result[6],
                "Flag"=>$result[7]
            );
        }
        return $arrResult;
    }//END: getOfferCompletionLate()

    public function getOfferProfile($offerCode){

    }//END: getOfferProfile()

    public function getOfferReach($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferReach]($offerCode)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ){
            $arrResult[] = array(
                $result[0]//Customer ID
                , $result[1] // OfferCode
                , $result[2] // Contact Date
                , $result[3] // String Value
                , $result[4] // Age
                , $result[5] // Gender
                , $result[6] // Status
                , $result[7] // Event Type
                , $result[8] // Income
                , $result[9] // Occupation
                , $result[10] // Education
                , $result[11] // Marital Status
                , $result[12] // Childen Flag
                , $result[13] // Channel
                , $result[15] // Staff No
                , $result[16] // Personal Income Range
                , $result[17] // Zipcode
                , $result[18] // Zipcode 2 digit
                , $result[19] // Location
            );
        }
        return $arrResult;
    }//END: getOfferReach()

    public function getOfferUniqueReach(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferCompletionRate]}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ){
            $arrResult[] = array(
                "offerCode"=>$result[0],
                "Name"=>$result[1],
                "Description"=>$result[2],
                "Type"=>$result[3],
                "Limit"=>$result[4],
                "Used"=>$result[5],
                "Rate"=>$result[6],
                "Flag"=>$result[7]
            );
        }
        return $arrResult;
    }//END: getOfferUniqueReach()

    public function getOfferAttibute($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferAttibute]($offerCode)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ){
            $arrResult[] = array(
                $result[0]
                , $result[1]
                , $result[2]
                , $result[3]
                , $result[4]
                , $result[5]
            );
        }
        return $arrResult;
    }//END: getOfferAttibute()

    public function getOfferReportImp($offerCode , $type){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferReportImp]($offerCode, $type)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $arrResult = null;
        if($type == 1):
            while( $result = sqlsrv_fetch_array($query) ){
                $arrResult[] = array(
                    $result[0] //dates
                , $result[1] //imp
                , $result[2] //ur
                );

            }
        elseif($type == 2):
            while( $result = sqlsrv_fetch_array($query) ){
                $arrResult[] = array(
                    $result[0] //ID
                , $result[1] //offerCode
                , $result[2] //date
                , $result[3] //target
                , $result[4] //imp
                , $result[5] //accum imp
                , $result[6] //ur
                , $result[7] //accum ur
                , $result[8] //accum blacklist
                , $result[9] // % achieved
                , $result[10] // current mpp
                , $result[11] // avg mpp
                , $result[12] //day
                , $result[13] //% per day
                );

            }
        endif;

        return $arrResult;
    }//END: getOfferCode()

    public function getOfferAccumUR($offerCode, $datetime){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferAccumUR]($offerCode, '$datetime')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);
        return $result;
    }//END: getOfferAccumUR()

    public function getOfferAccumBlacklist($datetime, $offerCode, $offerSubrLimit){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferAccumBlacklist]('$datetime', $offerCode, $offerSubrLimit)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);
//        while( $result = sqlsrv_fetch_array($query) ):
//            $arrResult = $result;
//        endwhile;
        return $result;

    }//END: getOfferAccumBlacklist

    public function getOfferLimitInfo($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [SP_CAMRUNDB_Verify_OfferLimit]($offerCode)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);
        return $result;
    }//END: getOfferLimitInfo()

    public function getOfferSubrLimitMppAttibute($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferSubrLimitMppAttibute]($offerCode)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);
        return $result;
    }//END: getOfferSubrLimitMppAttibute()

    public function getOfferMarketingScoreAll(){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferMarketingScoreAll]}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ):
            $arrResult[] = array(
                $result[0] //Offer ID
                , $result[1] //Offer Name
                , $result[3] //Marketing Score
                , $result[4] //Disable Status
            );
        endwhile;
        return $arrResult;
    }//END: getOfferMarketingScoreAll

    public function getOfferMarketingScoreWithOfferId($offerID){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferMarketingScore]($offerID)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);
        return $result;
    }//END: getOfferMarketingScore()

    public function getOfferImpHistory($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getOfferImpHistory]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ):
            $arrResult[] = array(
                $result[0]
                , $result[1]
                , $result[2]
            );
        endwhile;
        return $arrResult;
    }//END: getOfferImpHistory()

    public function getOfferImpUsubHistoryDate($offerCode, $type){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_offerImpUsub]($offerCode, $type)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ):
            $arrResult[] = array(
                $result[0] // Date
                , $result[1] // OfferCode
                , $result[2] // Offer Name
                , $result[3] // Usub
                , $result[4] // Imp
            );
        endwhile;
        return $arrResult;
    }//END: getOfferImpUsubHistoryDate()

    public function getOfferImpUsubHistoryHour($offerCode, $type){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_offerImpUsub]($offerCode, $type)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ):
            $arrResult[] = array(
                $result[0]
            , $result[1]
            , $result[2]
            );
        endwhile;
        return $arrResult;
    }//END: getOfferImpUsubHistoryHour()

    public function insertOfferReportImp($array, $getType){

        $conn = $this->connClass->sqlsrv_connection();

        $offerCode = intval($array[0]);
        $date = $array[1];
        $target = $array[2];
        $imp = $array[3];
        $accumImp = $array[4];
        $ur = $array[5];
        $accumUr = $array[6];
        $accumBlacklist = $array[7];
        $percentAchieved = ROUND($array[8], 2);
        $currMpp = $array[9];
        $avgMpp = ROUND($array[10], 2);
        $day = $array[11];
        $percentPerDay = $array[12];

        $sql = "{CALL [RSS_insertOfferReportImp](
            $getType
            , $offerCode
            , '$date'
            , $target
            , $imp
            , $accumImp
            , $ur
            , $accumUr
            , $accumBlacklist
            , $percentAchieved
            , $currMpp
            , $avgMpp
            , $day
            , $percentPerDay
        )}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_rows_affected($query);
        return $result;

    }//END: insertOfferReportImp();

    public function unpublishOfferReport($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_unpublishOfferReport]($offerCode)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_rows_affected($query);
        return $result;
    }//END: unpublishOfferReport

    public function updateOfferLimit($offerCode, $limit, $flag = 1){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_updateOfferLimit]($offerCode,$limit, $flag)}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);
        return $result;
    }//END: updateOfferLimit()

    //------------------------------------------------------------------------------------ Clear Blacklist Function Set

    public function getUAOfferTest($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getUAOffer_CAMDESDB]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ){
            $arrResult[] = array($result);
        }

        return $arrResult;
    }//END: getUAOfferTest()

    public function getUAOfferProc($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_getUAOffer_CAMRUNDB]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        while( $result = sqlsrv_fetch_array($query) ){
            $arrResult[] = array($result);
        }

        return $arrResult;
    }//END: getUAOfferProc()

    public function deleteOfferLimitTest($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_deleteOfferLimit_CAMDESDB]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_rows_affected($query);
        return $result;
//        if(!empty($result)){ $resultDeleteOfferLimit = true; } else { $resultDeleteOfferLimit = false; };
//        return array($result, $resultDeleteOfferLimit);
    }//END: deleteOfferLimitTest()

    public function deleteOfferLimitProc($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_deleteOfferLimit_CAMRUNDB]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_rows_affected($query);
        return $result;
    }//END: deleteOfferLimitProc()

    public function deleteOfferSubrLimitTest($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_deleteOfferSubrLimit_CAMDESDB]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_rows_affected($query);
        return $result;
    }//END: deleteOfferSubrLimit()

    public function deleteOfferSubrLimitProc($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_deleteOfferSubrLimit_CAMRUNDB]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_rows_affected($query);
        return $result;
    }//END: deleteOfferSubrLimitProc()

    public function deleteUACIBlackListTest($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_deleteUACIBlackList_CAMDESDB]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_rows_affected($query);
        return $result;
    }//END: deleteUACIBlackList()

    public function deleteUACIBlackListProc($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_deleteUACIBlackList_CAMRUNDB]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_rows_affected($query);
        return $result;
    }//END: deleteUACIBlackListProc()

    public function deleteUACIDefaultOffersTest($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_deleteUACIDefaultOffers_CAMDESDB]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_rows_affected($query);
        return $result;
    }//END: deleteUACIBlackList()

    public function deleteUACIDefaultOffersProc($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_deleteUACIDefaultOffers_CAMRUNDB]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_rows_affected($query);
        return $result;
    }//END: deleteUACIBlackList()

/*
    public function clearBlacklistTest($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
//        $sql = "{CALL [RSS_CAMDESDB_SpDeleteOfferLimit]('$offerCode')}";
        $sql = "{CALL [A_TEST_STOREPROC]('$offerCode')}";//DEBUG
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);

        return $result;
    }//END: clearBlackListTest()

    public function clearBlackListProd($offerCode){
        $conn = $this->connClass->sqlsrv_connection();
        $sql = "{CALL [RSS_CAMRUNDB_SpDeleteOfferLimit]('$offerCode')}";
        $query = sqlsrv_query($conn, $sql) or die( print_r( sqlsrv_errors(), true));
        $result = sqlsrv_fetch_array($query);

        return $result;
    }//END: clearBlackListProd()
*/
}//END: offer class
?>