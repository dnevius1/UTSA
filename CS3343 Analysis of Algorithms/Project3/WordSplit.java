/**
 * Application to take a string from
 * user and split the string based on
 * words matched from the Alice In 
 * Wonderland dictionary.
 * 
 * @author Daniel Nevius (khe996)
 * UTSA CS 3343 Project 3
 * Spring 2022
 */

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Scanner;
import java.util.Set;

public class WordSplit {

	public static void main(String[] args) throws IOException {
		List<String> aiwDictionary=new ArrayList<String>();
		Scanner myObj = new Scanner(System.in);
		Scanner sc= new Scanner(new File("src/data/aliceInWonderlandDictionary.txt"));
		sc.useDelimiter("\\n");
		while (sc.hasNext()) {
			aiwDictionary.add(sc.next());
		}
		System.out.println("Enter a string to match with words from the"
							+ "Alice In Wonderland dictionary: ");
		String str=myObj.nextLine();
		myObj.close();
		splitWord(str, aiwDictionary);
	}
	public static void splitWord(String str, List<String> aiwDictionary) {
		String p="";
		String k="";
		int wc=0;
        Set<String> aiwSet = new HashSet<>(aiwDictionary);
        /*Dynamic programming to track the indices 
         * where matches are found*/
        boolean[] matchFound = new boolean[str.length() + 1];
        matchFound[0] = true;
        for (int i = 1; i <= str.length(); i++) {
            for (int j = 0; j < i; j++) {
                if (matchFound[j] && aiwSet.contains(str.substring(j, i))) {
                	p+=str.substring(j, i) + " ";
                    matchFound[i] = true;
                    break;
                }
            }
        }
        /*Reformatting to ignore duplicates and words contained
         * in larger words. Replaces words we are ignoring with 0*/
        String words[]=p.split(" ");
        for (int i=0; i<words.length;i++) {
        	for(int j=0;j<words.length;j++) {
        		if(words[i].contains(words[j]) && !words[i].equals(words[j])) {
        			words[j]="0";
        		}
        	}
        }
        /*Only populates String k with words
         * that are not 0*/
        for (String word : words) {
        	if(!word.equals("0")) {
        		k+=word+" ";
        		wc++;
        	}
        }
        System.out.println(str+" can be split into "+wc+" words: "+k);
    }
}
