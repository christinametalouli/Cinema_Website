package com.cinema.rest;

import javax.ws.rs.POST;
import javax.ws.rs.Path;
import javax.ws.rs.Produces;

import java.sql.SQLException;

import javax.ws.rs.Consumes;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;
import javax.ws.rs.FormParam;

import com.cinema.dao.RegistrationRequestDao;
import com.cinema.dao.UserDao;
import com.cinema.model.RegistrationRequest;
import com.cinema.model.User;

@Path("/auth")
public class AuthenticationService {

    private UserDao userDao;

    public AuthenticationService() {
        try {
			this.userDao = new UserDao();
		} catch (ClassNotFoundException | SQLException e) {
			e.printStackTrace();
		}
    }

    @POST
    @Path("/login")
    @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
    @Produces(MediaType.APPLICATION_JSON)
    public Response login(@FormParam("username") String username, @FormParam("password") String password) {
        User authenticatedUser = userDao.authenticate(username, password);
        if (authenticatedUser != null) {
            return Response.ok(authenticatedUser.toJSON()).build();
        } else {
            return Response.status(401).entity("Invalid username or password").build();
        }
    }
    
//    @POST
//    @Path("/register")
//    @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
//    @Produces(MediaType.APPLICATION_JSON)
//    public Response register(
//            @FormParam("first_name") String firstName,
//            @FormParam("last_name") String lastName,
//            @FormParam("country") String country,
//            @FormParam("city") String city,
//            @FormParam("address") String address,
//            @FormParam("email") String email,
//            @FormParam("username") String username,
//            @FormParam("password") String password) {
//        
//        User user = new User(0, firstName, lastName, country, city, address, email, username, password, 1);
//        
//        try {
//            userDao.create(user);
//            return Response.status(201).entity(user.toJSON()).build();
//        } catch (Exception e) {
//            return Response.status(500).entity("Unable to create user. Error: " + e.getMessage()).build();
//        }
//    }
    
    @POST
    @Path("/register")
    @Consumes(MediaType.APPLICATION_FORM_URLENCODED)
    @Produces(MediaType.APPLICATION_JSON)
    public Response registrationRequest(
            @FormParam("first_name") String firstName,
            @FormParam("last_name") String lastName,
            @FormParam("country") String country,
            @FormParam("city") String city,
            @FormParam("address") String address,
            @FormParam("email") String email,
            @FormParam("username") String username,
            @FormParam("password") String password) {
        
        User user = new User(0, firstName, lastName, country, city, address, email, username, password, 1);
        System.out.println(user.toJSON());
        RegistrationRequest registrationRequest = new RegistrationRequest(user);
        
        try {
            RegistrationRequestDao registrationRequestDao = new RegistrationRequestDao();
            registrationRequestDao.create(registrationRequest);
            return Response.status(201).entity(registrationRequest.toJSON().toString()).build();
        } catch (Exception e) {
        	e.printStackTrace();
            return Response.status(500).entity("Unable to create registration request. Error: " + e.getMessage()).build();
        }
    }

}
