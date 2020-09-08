<?php
// to Update the maximum execution time
// Syntax php.ini
// max_execution_time=180 //180 seconds = 3 minutes 
// Method 2: Update .htaccess file 
// php_value max_execution_time 300 
// Method 3: Update your .php file Here, we have to place the below-mentioned syntax on top of the PHP script. 
// ini_set( 'max_execution_time', 300); 
// ini_set( 'max_execution_time', 0); //Unlimited time

// To set error reporting
// error_reporting(E_ALL); 

// To set false on display error
// ini_set( 'display_errors' , 0); 

// Start the session
session_start([
'cache_limiter' => 'private',    // Set the current cache limiter
'read_and_close' => true,    // Use read only sessions when session data does not need to be updated
]);

// To declare the variables types are strict
// declare(strict_types = 1); 

// Define Constant with Arrays
echo "<strong>Example for Define Constant with Arrays</strong><br/>";
define('NAME', array('Bala','Karthikeyan','Anandakumar'));
echo "<pre>".NAME[1]."</pre>";

// Using Composer loading custom package
require __DIR__ . '/vendor/autoload.php';

// Namespace as alias
use balakarthikeyan\HelloComposer\Index as indexclass;
use balakarthikeyan\HelloComposer\HelloPackage\SayPackage as packageclass;
echo "<strong>Example for Namespace as alias</strong><br/>";
$greeting = new indexclass();
echo "<pre>";
echo $greeting->greet();
echo "<br/>";
echo packageclass::world();
echo "<br/>";
echo $greeting->bye();
echo "</pre>";

// Identical Operator
echo "<strong>Example for Identical Operator</strong><br/>";
$a = new stdClass();
$a->foo = "bar";
$b = clone $a;
echo "<pre>";
var_dump($a === $b);
var_dump($a == $b);
echo "</pre>";

// Call by Reference
echo "<strong>Example for Call by Reference</strong><br/>";
function callByReference(&$str2) {
    $str2 .= 'Call By Reference';
    return  $str2;
}
$str = 'This is ';
echo "<pre>".callByReference($str)."</pre>";

// Spaceship Operator
echo "<strong>Example for Spaceship Operator</strong><br/>";
$arr = ['apple' ,'orange' , 'watermelon']; 
usort($arr, function($a, $b) { 
    return strlen($a) <=> strlen($b);  
});
echo "<pre>"; print_r($arr); echo "</pre>";

// Cryptographically Secure Pseudo Random Number Generator 
echo "<strong>Example for CSPRNG Functions</strong><br/>";
$bytes = random_bytes(5); // length in bytes
echo "<pre>";
echo "Random Bytes : ". bin2hex($bytes). "<br/>";
echo "Random Integer : ". random_int(100, 999). "<br/>";
echo "</pre>";

// Spread operator
echo "<strong>Example for Spread operator</strong><br/>";
$parts = ['apple', 'pear'];
$fruits = ['banana', 'orange', ...$parts, 'watermelon'];
echo "<pre>"; print_r($fruits); echo "</pre>";

// Null coalescing operator
echo "<strong>Example for Null coalescing operator</strong><br/>"; 
$user = $_POST['user'] ?? 'Guest'; //PHP 7.2
// $user = isset($_POST['user']) ? $_POST['user'] : 'Guest'; //PHP 5.2
echo "<pre>".$user."</pre>";

// Ternary operator shorthand
echo "<strong>Example for Ternary operator shorthand</strong><br/>";
$user = $_POST['user'] ?: 'Guest';
echo "<pre>".$user."</pre>";

// trait
echo "<strong>Example for trait</strong><br/>";
trait Example1 {
    public $square;
    public function add(int $var1, int $var2)  {
        return $var1 + $var2;
    }
}
trait Example2 {
    public function multiplication(int $var1, int $var2) : int {
        return $var1 * $var2;
    }
}
class traitExample {
    use Example1;
    use Example2;
    //Overriding the trait function
    public function multiplication(int $var1, int $var2) : float {
        return $var1 / $var2;
    }
    public function calculate($var1, $var2) {
        //Accessing trait variable 
        $square = 10;
        echo "<pre>";
        echo "Result of Addition:" . $this->add($var1, $var2) . "<br/>";
        echo "Result of Multiplication:" . $this->multiplication($var1, $var2). "<br/>";
        echo "Result of Square:" . ($square * $square). "<br/>";
        echo "</pre>";
    }
}
$o = new traitExample();
$o->calculate(15, 2);

echo "<strong>Example for interface</strong><br/>";
interface MyInterface {
    public function examplemethod1();
    public function examplemethod2();
}
class MyInterClass implements MyInterface {
    public function examplemethod1() {
        echo "ExampleMethod1 Called" . "<br/>";
    }

    public function examplemethod2() {
        echo "ExampleMethod2 Called" . "<br/>";
    }
}
$ob = new MyInterClass;
echo "<pre>";
$ob->examplemethod1();
$ob->examplemethod2(); 
echo "</pre>";

// Classic closure
echo "<strong>Example for Classic closure</strong><br/>";
$param = 'Classic';
$closure = function ($arg) use ($param) {
    return 'Parameter : ' . $param . ', Argument : ' . $arg;
};
// Closure
echo "<pre>";
echo "Closure Class : ". get_class($closure)."<br/>";
// Object
echo "Closure Object : ". gettype($closure)."<br/>";
// Call
echo "Closure Call : ". $closure('Closure')."<br/>";
echo "</pre>";

// Short closure
echo "<strong>Example for Short Closure</strong><br/>";
$param = "Short Closure";
$func = fn() => "Hi from  " . $param ;
echo "<pre>".$func()."</pre>";

// More on Closures, Bind(), Call()
echo "<strong>Example on Closures, Bind(), Call()</strong><br/>";
class A {
    public $context = 'Hello From More on Closures';
}
$closure = function () { return $this->context; };
echo "<pre>";
$getHi = $closure->bindTo(new A, 'A');
echo $getHi() . " bindTo()"."<br/>";
$getHi = Closure::bind($closure, new A, 'A');
echo $getHi() . " bind()"."<br/>";
$getHi = $closure->call(new A);
echo $getHi . " call()"."<br/>";
echo "</pre>";

// Anonymous Class
echo "<strong>Example for Anonymous Class</strong><br/>";
$anonymous = new class {
    public function AnonymousClass($name) {
        return "Hello $name";
    }
};
echo "<pre>".$anonymous->AnonymousClass('Anonymous Class')."</pre>";

// Weak Reference
echo "<strong>Example for WeakReference</strong><br/>";
// Save a link to an object that does not prevent its destruction
$obj = new stdClass;
$obj->variable = "foobar";
$obj->func = function () { return $obj->variable; };
// $obj->func->bindTo($obj);
$weakref = WeakReference::create($obj);
echo "<pre>";
var_dump($weakref->get());
unset($obj);
var_dump($weakref->get());
echo "</pre>";

//Generator Yield
function getUniqueId() {
    $i = 1;
    while ($i > 0) {
        $v = (yield $i);
        if ($v !== null){
            $i = $v;
        } else  $i++;
    }
}
echo "<strong>Example for Generator Yield</strong><br/>";
echo "<pre>";
$getId = getUniqueId();
echo "Prints: ". $getId->current(). "</br>"; //Prints: 1
$getId->next();
echo "Prints: ". $getId->current(). "</br>"; //Prints: 2
$getId->send(10);
echo "Prints: ". $getId->current(). "</br>"; //Prints: 10
$getId->next();
echo "Prints: ". $getId->current(). "</br>"; //Prints: 11
echo "</pre>";

// Generator Class
echo "<strong>Example for Generator Class</strong><br/>";
function GeneratorP(){
    yield 'a';
    yield 'key2' => 'b'; 
}
function Generator() {
    yield from GeneratorP();
    yield 'c';
    yield 'key4' => 'd';
    return "e";
}
$itr = Generator();
echo "<pre>";
foreach ($itr as $key => $val){
    echo $key . "=>". $val . "</br>";
}
echo $itr->getReturn() . "</br>" ;
echo "</pre>";

// Type declarations
echo "<strong>Example for Type declarations</strong><br/>";
function printMe( int $var ) {
    return $var;
}
echo "<pre>Argument type : ".printMe( 200 )."</pre>";

// Return Type declarations
function modulus(int $a, int $b) : float {
    return $a / $b;
}
echo "<pre>Return type : ".modulus ( 5 , 12 )."</pre>";

//Generator with functions & iterable Type hinting
function itrExample(iterable $itr) {
    echo "<pre>";
    while ( $itr->valid() ){
        echo $itr->key(). " : ". $itr->current();
        echo "<br/>";
        $itr->next();
    }
    echo $itr->getReturn() . "</br>";
    echo "</pre>";
}
$itr = (function() {
    yield 'step 1';
    yield 'step 2';
    return 'checkout';
})();
itrExample($itr); 

// Type Properties 
echo "<strong>Example for Type Properties</strong><br/>";
class TypedUser {
    public int $id;
    private string $name;
    public ?string $lastname = null; //Nullable types with Default value
    // protected ClassName $classType;
    // public static iterable $staticProp;
    // var bool $flag;
    public function setName(string $name) : void {
        $this->name = $name;
    }
    public function getName() : string {
        return $this->name;
    }
}
$obj = new TypedUser;
$obj->setName('Balakarthikeyan');
echo "<pre>Class properties : ".$obj->getName() . $obj->lastname."</pre>";

//Class Type declarations 
class MyClass {
	public $var = 'Hello World';
}
function TestMyClass(MyClass $myclass){
	return $myclass->var;
}
$myclass = new MyClass;
echo "<pre>Class Type : ".TestMyClass($myclass)."</pre>";

// Covariant return type:
interface ExampleFactory {
	public function make() : object;
}
class UserFactory implements ExampleFactory {
	public function make() : MyClass {
        $myclass = new MyClass;
        return $myclass;
    }
}
$myclass = new UserFactory;
echo "<pre>Covariant return type : ".$myclass->make()->var."</pre>";

// Contravariant parameter type:
interface Concatable {
	function concat(Iterator $input); 
}
class Collection implements Concatable {
	function concat(iterable $input) {

    }
}

// Custom Exception
class MyCompanyException extends Exception {
    public function errorMessage() {
        // Error Message
        $errorMsg = 'Error on line ' . $this->getLine() . ' in ' . $this->getFile(). ': <b>' . $this->getMessage() . '</b> is not a valid </br>';
        return $errorMsg;
    }
}

class Arithematic extends MyCompanyException {
    public function Sum($a, $b) {
        return ($a + $b);
    }
    public function Subtract($a, $b) {
        return ($a-$b);
    }
    public function checkException() {
        try {
            echo "this is our try block" . "</br>";
            $var = 0 - 9;
            throw new Exception(" Subtract Exception ");
            throw new MyCompanyException(" Subtract Exception ");
        } catch (MyCompanyException $e) {
            echo $e->errorMessage();
        } catch (Exception $e) {
            echo "Something went wrong !! <b>" . $e->message . "</b> </br>";
            echo "<b>Message : </b>". $e->getMessage() . "</br>"; //message of exception
            echo "<b>Code : </b>". $e->getCode() . "</br>"; //code of exception
            echo "<b>File : </b>". $e->getFile() . "</br>"; //source filename
            echo "<b>Line : </b>". $e->getLine() . "</br>"; //source line
            echo "<pre>";
            print_r($e->getTrace()) . "</br>"; //n array of the backtrace()
            echo "</pre>";
            echo "<b>Trace String : </b>". $e->getTraceAsString() . "</br>"; //formatted string of trace
        } finally {
            echo "this part is always executed in finally block" . "</br>";
        }
    }
}

class GenricFunctions extends Arithematic {
    public function AreaOfSquare($a) {
        return ($a * $a);
    }
    public function AreaOfRect($l, $b) {
        return ($l * $b);
    }
}
echo "<strong>Example for Inheritance</strong><br/>";
echo "<pre>";
$obj = new GenricFunctions();
echo "Addition : " . $obj->Sum(5, 4)."</br>";
echo "Subtract : " . $obj->Subtract(5, 4)."</br>";
echo "Area Of Square : " . $obj->AreaOfSquare(5)."</br>";
echo "Area Of Rectangle : " . $obj->AreaOfRect(5, 4)."</br>";
echo "</pre>";

echo "<strong>Example for Exception</strong><br/>";
echo "<pre>";
$obj->checkException();
echo "</pre>";

// Exception as Throwable
echo "<strong>Example for Throwable</strong><br/>";
try {
    throw new Exception("Bla Bla");
} catch (Throwable $t) {
    echo "Throwable: ".$t->getMessage()."<br/>"; 
}

// Error
echo "<strong>Example for Error</strong><br/>";
try {
    $result = eval("var_dup(1);");
} catch (Error $e) {
    echo "Error: ".$e->getMessage()."<br/>";
}

// Type error
echo "<strong>Example for Type error</strong><br/>";
try {
    function add(int $a, int $b):int {
        return $a + $b;
    }
    echo add(array(), array());
} catch (TypeError $t) {
    echo "Type error: ".$t->getMessage()."<br/>";
}

/* 
// Parse Error
echo "<strong>Example for Parse Error</strong><br/>";
try {
    // require 'file-with-parse-error.php';
    $result = eval("a = $b");
} catch (ParseError $e) {
    echo "Parse Error: " . $e->getMessage() . "<br/>";
} 
*/
echo "<br/>";
echo "<strong>Example for Reference</strong><br/>";
class Config{
    private $values = [];
    public function getValues() {
        return $this->values;
    }
}
$config = new Config();
$vals = $config->getValues();
$vals['test'] = 'test1';
echo "<pre>Method 1 : <br/>Test Value = ".$vals['test']."</pre>";

class Config1{
    private $values = [];
    // return a REFERENCE to the actual $values array
    public function &getValues() {
        return $this->values;
    }
}
$config = new Config1();
$config->getValues()['test'] = 'test2';
echo "<pre>Method 2 : <br/>Test Value = ".$config->getValues()['test']."</pre>";

class Config2 {
    private $values;
    // using ArrayObject
    public function __construct() {
        $this->values = new ArrayObject();
    }
    public function getValues() {
        return $this->values;
    }
}

$config = new Config2();
$config->getValues()['test'] = 'test3';
echo "<pre>Method 3 : <br/>Test Value = ".$config->getValues()['test']."</pre>";

class Config3 {
    private $values = [];
    public function setValue($key, $value) {
        $this->values[$key] = $value;
    }
    public function getValue($key) {
        return $this->values[$key];
    }
}

$config = new Config3();
$config->setValue('test', 'test4');
echo "<pre>Method 4 : <br/>Test Value = ".$config->getValue('test')."</pre>";

// jump:    //Label for GOTO statement
// echo 'This should be printed.';
// goto jump;
?>