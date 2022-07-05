myprogram: main.o cards.o
	gcc main.o cards.o -o myprogram
main.o: main.c cards.h
	gcc -c main.c -o main.o
cards.o: cards.c cards.h
	gcc -c cards.c -o cards.o
clean:
	rm -rf *.o
	rm myprogram
