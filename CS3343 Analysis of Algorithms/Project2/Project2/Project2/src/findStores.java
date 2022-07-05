/**
 * Daniel Nevius (khe996)
 * UTSA CS 3343 - Project 2
 * Spring 2022
 * Program to find a specified number of closest stores to a certain location.
 * Data read from CSV files.
 */
import java.io.File;
import java.io.FileNotFoundException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Random;
import java.util.Scanner;

public class findStores {
	ArrayList<Store> storeList = new ArrayList<Store>();
	
	public static void main(String[] args) throws FileNotFoundException {
		findStores f = new findStores();
		f.loadData();
		f.findDistance();
	}
	/*Adds store to list*/
	public void addStore(Store s) {
		this.storeList.add(s);
	}
	/*Uses scanner to read file and populate a list of stores*/
	public void loadData() throws FileNotFoundException {
		int id;
		String address;
		String city;
		String state;
		int zipCode;
		double latitude;
		double longitude;
		Scanner sc= new Scanner(new File("data/WhataburgerData.csv"));
		sc.useDelimiter(",|\\n");
		sc.nextLine();
		while (sc.hasNext()) {
			id = Integer.valueOf(sc.next());
			address = sc.next();
			city = sc.next();
			state = sc.next();
			zipCode = Integer.valueOf(sc.next());
			latitude = Double.valueOf(sc.next());
			longitude = Double.valueOf(sc.next());
			Store s = new Store(id, address, city, state, zipCode, latitude, longitude);
			addStore(s);
		}
	}
	/*Finds the distance between the query location and every store on the list*/
	public void findDistance() throws FileNotFoundException {
		double qLat;
		double qLon;
		String qNum;
		int k;
		Scanner sc= new Scanner(new File("data/Queries.csv"));
		sc.useDelimiter(",|\\n");
		sc.nextLine();
		while (sc.hasNext()) {
			qLat = Double.valueOf(sc.next());
			qLon = Double.valueOf(sc.next());
			qNum = sc.next();
			qNum = qNum.trim();
			k = Integer.parseInt(qNum);
			for (int i = 0; i < storeList.size(); i++) {
				storeList.get(i).computeDistance(qLat, qLon);
			}
			int n = storeList.size();
			kthSmallestNum(storeList, 0, n-1, k);
			insertionSort(storeList, k);
			print(storeList, k, qLat, qLon);
		}
			
	}
	/*Finds and returns kth smallest distance in ArrayList*/
	public Store kthSmallestNum(ArrayList<Store> storeList, int l, int r, int k) {
		if (k > 0 && k <= r-1+1) {
			int pos = randomPartition(storeList, l, r);
			if (pos-l == k-1) {
				return storeList.get(pos);
			}
			if (pos-l > k-1 ) {
				return kthSmallestNum(storeList, l, pos-1, k);
			}
			return kthSmallestNum(storeList, pos+1, r, k-pos+l-1);
		}
		return storeList.get(k);
	}
	public void swapElements(ArrayList<Store> storeList, int i, int j) {
		Collections.swap(storeList, i, j);
	}
	/*Selects partition and moves all smaller distance values to the left
	 * and larger values to the right*/
	public int partition(ArrayList<Store> storeList, int l, int r) {
		double x = storeList.get(r).distance;
		int i=l;
		for (int j=l; j<=r-1; j++) {
			if (storeList.get(j).distance <= x) {
				swapElements(storeList, i, j);
				i++;
			}
		}
		swapElements(storeList, i, r);
		return i;
	}
	public int randomPartition(ArrayList<Store> storeList, int l, int r) {
		int n = r-l+1;
		int pivot = new Random().nextInt(n);
		swapElements(storeList, l+pivot, r);
		return partition(storeList, l, r);
	}
	/*Sorting the ArrayList elements out to the kth element*/
	void insertionSort(ArrayList<Store> storeList, int k) {
		for (int i = 1; i < k; i++) {
			double key = storeList.get(i).distance;
			int j = i-1;
			while (j >= 0 && storeList.get(j).distance > key) {
				Collections.swap(storeList, j+1, j);
						j = j-1;
			}
			storeList.get(j+1).distance = key;
		}
	}
	/*Prints the k closest stores to the query*/
	private void print(ArrayList<Store> storeList, int k, double qLat, double qLon) {
		System.out.println("The " +k+ " closest Stores to ("+qLat+","+qLon+"):" );
		for (int i = 0; i < k; i++) {
			System.out.print("Store #"+storeList.get(i).id+". "+storeList.get(i).address+" ,"+storeList.get(i).city+" ,"+storeList.get(i).state+" ,"+storeList.get(i).zipCode+" - ");
			System.out.format("%.2f", storeList.get(i).distance);
			System.out.println();
		}
		System.out.println();
		
	}
}
