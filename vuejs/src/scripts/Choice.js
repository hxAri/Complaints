
/*
 * Choice
 *
 * Return a random pick from an Array or Object.
 *
 * @params Array values
 *
 * @return Mixed
 */
export default function Choice( values )
{
	return( values[Math.floor( Math.random() * values.length )] );
};