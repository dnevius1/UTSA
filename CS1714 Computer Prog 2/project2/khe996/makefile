myProgram: main.o route-records.o
	gcc main.o route-records.o -o myProgram
main.o: route-records.h main.c
	gcc -c main.c
route-records.o: route-records.h route-records.c
	gcc -c route-records.c
clean:
	rm *.o
	rm myProgram
