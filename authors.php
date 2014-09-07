<?php
$pageTitle="Автор" ;
include 'includes/header.php';
include 'includes/conn.php';
echo '<a href="index.php">Книги</a>';
$authorid=$_GET['id'];
$authors=mysqli_query($connect, 'SELECT * FROM books INNER JOIN books_authors ON books.book_id = books_authors.book_id
 INNER JOIN authors ON books_authors.author_id = authors.author_id
 WHERE books_authors.book_id IN (SELECT books_authors.book_id
            FROM books_authors INNER JOIN authors ON books_authors.author_id = authors.author_id
            WHERE authors.author_id = "'.$authorid.'")');
if(!$authors){
            echo 'Грешка в данните';
           }
          
           $result=array();

while($row=$authors->fetch_assoc()){
                                  $result[$row['book_id']]['book_title']=$row['book_title'];
                                  $result[$row['book_id']]['authors'][$row['author_id']] = $row['author_name'];
                                  } 

                                  
echo '<table border="1"><tr><td><b>Книга</b></td><td><b>Автор(и)</b></td></tr>';

foreach ($result as $title) {
                             echo '<tr><td>'.$title['book_title'].'</td><td>';
                                                         
                             
                             foreach ($title['authors'] as $aid=>$authorname){
                                                                     
                                                                    
                                                                    echo '<a href=authors.php?id='.$aid.'>'.$authorname.'&nbsp'; 
                                                                    }
                             echo '</a></td></tr>';
                            }  
echo '</table>';
if (isset($aid)!=$authorid){
                                 echo 'НЯМА ТАКЪВ АВТОР   (<a href="newauthor.php">Добави автор</a>)';
                                }
elseif ($authorid==NULL){header('Location: index.php');}
?>
