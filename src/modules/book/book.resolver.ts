import { Args, Mutation, Query } from "@nestjs/graphql";
import { Resolver } from "@nestjs/graphql";

@Resolver('Book')
export class BookResolver {
    private books = [
        { 
            id: 1, 
            title: 'Harry Potter', 
            author: 'George Orwell',
            price: 10,
        },
        { 
            id: 2, 
            title: 'Harry Potter', 
            author: 'George Orwell',
            price: 10,
        },            { 
            id: 3, 
            title: 'Harry Potter', 
            author: 'George Orwell',
            price: 10,
        },
    ]

    @Query('books')
    getBooks() {
        return [
            { 
                id: 1, 
                title: 'Harry Potter', 
                author: 'George Orwell',
                price: 10,
            },
            { 
                id: 2, 
                title: 'Harry Potter', 
                author: 'George Orwell',
                price: 10,
            },            { 
                id: 3, 
                title: 'Harry Potter', 
                author: 'George Orwell',
                price: 10,
            },
        ];
        return this.books;
    }

    @Query('book')
    getBookbyId(@Args('id') id: number) {
        return this.books.find((book) => book.id == id);
    }

    @Mutation('addbook')
    addBook(@Args('title') title: string, @Args('price') price: number) {
        const sortedBooks = this.books.sort((a, b) => a.id - b.id);
        const lastId = sortedBooks.length > 0 ? sortedBooks[sortedBooks.length - 1].id : 0;
        const newBook = {
            id: lastId + 1,
            title,
            price,
            author: 'Unknown',
        };
        this.books.push(newBook);
        return newBook;
    }

    @Mutation('deleteBook')
    deleteBook(@Args('id') id: number) {
      try {
        const bookIndex = this.books.findIndex((book) => book.id == id);
        if (bookIndex === -1) {
          return false;
        }
        this.books.splice(bookIndex, 1);
        return true;  
      } catch (e) {
        console.error(e);  
        return false; 
    }
}
}
