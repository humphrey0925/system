<?PHP
function processCustomerAdd(){
    $response = file_get_contents("sourcecode/customerAdd.min.html");
    for ($i=1; $i <= 10; $i++) 
        $response = strtr($response,array('%data%' => "$i customerAdd <br></a><a>%data%",));
    $response = strtr($response,array('<a>%data%</a>' => "",));
    $GLOBALS['customerAdd'] = $response;
}
?>