<?php
/* Stack OverFlow

 @MikeLewis answer is by far a simpler approach, but it only gives you a range of latitude and longitude, and drawing
 randomly from that might give you points outside the given radius.

The following is a bit more complicated, but should give you 'better' results. (The chances are that isn't necessary,
but I wanted to have a go :) ).

As with @MikeLewis' answer the assumption here is that Earth is a sphere. We use this not only in the formulas,
but also when we exploit rotational symmetry.

The theory

First we take the obvious approach of picking a random distance $distance (less then $radius miles) and try to find a
random point $distance miles away. Such points form a circle on the sphere, and you can quickly convince yourself a
straightforward parametrisation of that circle is hard. We instead consider a special case: the north pole.

Points which are a set distance away from the north pole form a circle on the sphere of fixed latitude
( 90-($distance/(pi*3959)*180). This gives us a very easy way of picking a random point on this circle: it will have
known latitude and random longitude.

Then we simply rotate the sphere so that our north pole sits at the point we were initially given. The position of our
random point after this rotation gives us the desired point.

The code

Note: The Cartesian <--> Spherical co-ordinate transformations used here are different to what is usual in literature.
My only motivation for this was to have the z-axis (0,0,1) was pointing North, and the y-axis (0,1,0) pointing towards
you and towards the point with latitude and longitude equal to 0. So if you wish to imagine the earth you are looking
at the Gulf of Guinea.

CODE:
 */

/**
* Given a $centre (latitude, longitude) co-ordinates and a
* distance $radius (miles), returns a random point (latitude,longtitude)
* which is within $radius miles of $centre.
*
* @param  array $centre Numeric array of floats. First element is
*                       latitude, second is longitude.
* @param  float $radius The radius (in miles).
* @return array         Numeric array of floats (lat/lng). First
*                       element is latitude, second is longitude.
*/
function generate_random_point($latitude, $longitude, $radius )
{

    $centre = [$latitude, $longitude];

    $radius_earth = 3959; //miles

    //Pick random distance within $distance;
    $distance = lcg_value()*$radius;

    //Convert degrees to radians.
    $centre_rads = array_map( 'deg2rad', $centre );

    //First suppose our point is the north pole.
    //Find a random point $distance miles away
    $lat_rads = (pi()/2) -  $distance/$radius_earth;
    $lng_rads = lcg_value()*2*pi();


    //($lat_rads,$lng_rads) is a point on the circle which is
    //$distance miles from the north pole. Convert to Cartesian
    $x1 = cos( $lat_rads ) * sin( $lng_rads );
    $y1 = cos( $lat_rads ) * cos( $lng_rads );
    $z1 = sin( $lat_rads );


    //Rotate that sphere so that the north pole is now at $centre.

    //Rotate in x axis by $rot = (pi()/2) - $centre_rads[0];
    $rot = (pi()/2) - $centre_rads[0];
    $x2 = $x1;
    $y2 = $y1 * cos( $rot ) + $z1 * sin( $rot );
    $z2 = -$y1 * sin( $rot ) + $z1 * cos( $rot );

    //Rotate in z axis by $rot = $centre_rads[1]
    $rot = $centre_rads[1];
    $x3 = $x2 * cos( $rot ) + $y2 * sin( $rot );
    $y3 = -$x2 * sin( $rot ) + $y2 * cos( $rot );
    $z3 = $z2;


    //Finally convert this point to polar co-ords
    $lng_rads = atan2( $x3, $y3 );
    $lat_rads = asin( $z3 );

    return array_map( 'rad2deg', array( $lat_rads, $lng_rads ) );
}

?>