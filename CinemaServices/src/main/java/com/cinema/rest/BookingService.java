package com.cinema.rest;

import java.sql.SQLException;
import java.util.List;

import javax.ws.rs.*;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;

import org.json.JSONArray;
import org.json.JSONObject;

import com.cinema.dao.BookingDao;
import com.cinema.dao.MovieDao;
import com.cinema.dao.UserDao;
import com.cinema.model.Booking;
import com.cinema.model.Movie;
import com.cinema.model.User;

@Path("/bookings")
public class BookingService {
	private BookingDao bookingDao;
	private MovieDao movieDao;
	private UserDao userDao;

	public BookingService() {
		try {
			this.bookingDao = new BookingDao();
			this.movieDao = new MovieDao();
			this.userDao = new UserDao();
		} catch (ClassNotFoundException | SQLException e) {
			this.bookingDao = null;
			this.movieDao = null;
			this.userDao = null;
		}
	}

	@GET
	@Path("/{userId}")
	@Produces(MediaType.APPLICATION_JSON)
	public Response getBookings(@PathParam("userId") int userId) {
		try {
			User user = userDao.findById(userId);
			if (user == null) {
				return Response.status(404).entity("User not found").build();
			}
			List<Booking> bookings = bookingDao.getBookingsByUserId(userId);
			if (bookings.isEmpty()) {
				return Response.status(404).entity("No bookings found for user with ID " + userId).build();
			}
			JSONArray jsonArray = new JSONArray();
			for (Booking booking : bookings) {
				JSONObject jsonObject = new JSONObject();
				jsonObject.put("id", booking.getId());
				jsonObject.put("user_id", booking.getUserId());
				jsonObject.put("movie_id", booking.getMovieId());
				jsonObject.put("booking_date", booking.getBookingDate());
				Movie movie = movieDao.getMovieById(booking.getMovieId());
				if (movie != null) {
					jsonObject.put("movie_name", movie.getName());
				}
				jsonArray.put(jsonObject);
			}
			return Response.ok(jsonArray.toString()).build();
		} catch (Exception e) {
			return Response.status(500).entity("Unable to retrieve bookings. Error: " + e.getMessage()).build();
		}
	}

	@POST
	@Path("/new")
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	public Response createBooking(String body) {
		Booking booking = Booking.fromJSON(body);
		if (booking == null) {
			return Response.status(Response.Status.BAD_REQUEST).entity("malformed body").build();
		}
		
	    try {
	    	
	        BookingDao bookingDao = new BookingDao();
	        bookingDao.createBooking(booking);

	        JSONObject jsonObject = booking.toJSON();
	        return Response.status(201).entity(jsonObject.toString()).build();
	    } catch (Exception e) {
	        return Response.status(500).entity("Unable to create booking. Error: " + e.getMessage()).build();
	    }
	}
}
