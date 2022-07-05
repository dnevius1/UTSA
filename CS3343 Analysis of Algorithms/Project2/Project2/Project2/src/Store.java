/**
 * Daniel Nevius (khe996)
 * UTSA CS 3343 - Project 2
 * Spring 2022
 * Class of Store objects
 */
import java.lang.Math;
public class Store {
	int id;
	String address;
	String city;
	String state;
	int zipCode;
	double latitude;
	double longitude;
	double distance;
	
	public Store(int id, String address, String city, String state, int zipCode, double latitude, double longitude) {
		super();
		this.id = id;
		this.address = address;
		this.city = city;
		this.state = state;
		this.zipCode = zipCode;
		this.latitude = latitude;
		this.longitude = longitude;
		this.distance = -1;
	}
	/*Computes and returns the distance between two coordinates*/
	public void computeDistance(double otherLat, double otherLong) {
		double radiusOfEarth = 3958.8;
		
		double lat1 = Math.toRadians(latitude);
		double lat2 = Math.toRadians(otherLat);
		double long1 = Math.toRadians(longitude);
		double long2 = Math.toRadians(otherLong);
		
		double a = Math.pow(Math.sin((lat2 -lat1)/2), 2) + Math.cos(lat1)*Math.cos(lat2)*Math.pow(Math.sin((long2-long1)/2), 2);
		double c = 2*Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
		distance = radiusOfEarth*c;
	}

	
}
