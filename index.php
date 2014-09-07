<?php
  $pageTitle='Списък';
  include 'includes/header.php';
  include 'includes/conn.php';                 
  
  if (isset($_GET['sort'])) {
    if ($_GET['sort'] == 'asc') {
        $sortSql = 'asc';
        $sortFix = 'desc';
    } else if ($_GET['sort'] == 'desc') {
        $sortSql = 'desc';
        $sortFix = 'asc';
    }
} else {
    $sortSql = 'asc';
    $sortFix = 'desc';
}
  if (isset($_POST['postSearch'])) {
    $key = htmlspecialchars(mysqli_real_escape_string($connect, trim($_POST['searchKey'])));
    $sqlSearch = 'WHERE book_title LIKE "%' . $key . '%"';
    
} else { 
    $sqlSearch = '';
    
    
}
$books=mysqli_query($connect, 'SELECT * FROM books LEFT JOIN books_authors 
ON books.book_id=books_authors.book_id LEFT JOIN authors ON books_authors.author_id=authors.author_id  ' .$sqlSearch. ' Order By book_title '.$sortSql.'');

if(!$books){
            echo 'Грешка в данните';
           }
           
$result=array();

while($row=$books->fetch_assoc()){
                                  $result[$row['book_id']]['book_title']=$row['book_title'];
                                  $result[$row['book_id']]['authors'][$row['author_id']]=$row['author_name'];
                                  }

                                
echo '<table border="1"><tr><td><b>Книга<a href="newbook.php">(добави)</a></b>    <a href=index.php?sort='.$sortFix.'>Сорт</a></td><td><b>Автор(и)<a href="newauthor.php">(добави)</a></b></td></tr>';

foreach ($result as $title) {
                             echo '<tr><td>'.$title['book_title'].'</td><td>';
                            foreach ($title['authors'] as $aid=>$authorname){
                                                                   echo '<a href=authors.php?id='.$aid.'>'.$authorname.'&nbsp'; 
                                                                   }
                             echo '</a></td></tr>';
    
                            }  
echo '</table>';

?>


<form action="index.php" method="POST">
        <input type="submit" name="postSearch" value="Search Book" id="postSearch"/>
        <input type="text" name="searchKey" id="searchKey"/>
        <?php
        if (isset($_POST['postSearch']) ) {
            if($key==NULL){
        echo 'Въведи поне един символ';
    }else{ if(!isset($title['book_title'])
            ) {
  echo ' Няма съвадение с въведеното <b>'.$key.' </b> !';
}
    echo ' <a href="index.php">Върни се в списъка </a>';}
} 
       
                ?>
    </form>
<?php
include 'includes/footer.php';
?>
