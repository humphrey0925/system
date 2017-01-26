<?PHP
function processCustomerManage(){
    $response = file_get_contents("sourcecode/customerManage.min.html");
    for ($i=1; $i <= 10; $i++) 
        $response = strtr($response,array('%data%' => "$i customerManage <br></a><a>%data%",));
    $response = strtr($response,array('<a>%data%</a>' => "",));
    $GLOBALS['customerManage'] = $response;
}
?>