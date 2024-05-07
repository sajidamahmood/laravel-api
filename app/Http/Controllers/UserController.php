<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;



/**
 * @OA\Info(
 *     title="My First API laravel 11",
 *     version="0.1"
 * )
 */

class UserController extends Controller
{




    public function index()
    {
        $users = User::all();

        return response()->json(['users' => $users]);
    }

    /**
 * @OA\Post(
 *     path="/api/users",
 *     tags={"Users"},
 *     summary="Store a new user",
 *     description="Create a new user with name, email, and password",
 *     operationId="storeUser",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User details",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="John Doe",
 *                     description="User's name"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     example="john@example.com",
 *                     description="User's email address"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string",
 *                     format="password",
 *                     example="password123",
 *                     description="User's password"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="User created successfully"
 *             ),
 *             @OA\Property(
 *                 property="user",
 *                 ref="#/components/schemas/User"
 *             )
 *         )
 *     )
 * )
 */


    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',
            'password_confirmation' => 'required|string',
        ]);

        // Créer un nouvel utilisateur
        $user = User::create($validatedData);

        // Retourner l'utilisateur créé au format JSON
        return response()->json(['user' => $user], 201);
    }

    /**
 * @OA\Get(
 *     path="/api/users/{id}",
 *     tags={"Users"},
 *     summary="Retrieve a user",
 *     description="Get details of a specific user by ID",
 *     operationId="showUser",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user to retrieve",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User details retrieved successfully",
 *         @OA\JsonContent(
 *             ref="#/components/schemas/User"
 *         )
 *     )
 * )
 */


    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }

    /**
 * @OA\Put(
 *     path="/api/users/{id}",
 *     tags={"Users"},
 *     summary="Update a user",
 *     description="Update details of a specific user by ID",
 *     operationId="updateUser",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user to update",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Updated user details",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     example="Updated John Doe",
 *                     description="User's updated name"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     example="updatedjohn@example.com",
 *                     description="User's updated email address"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string",
 *                     format="password",
 *                     example="updatedpassword123",
 *                     description="User's updated password"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="User updated successfully"
 *             ),
 *             @OA\Property(
 *                 property="user",
 *                 ref="#/components/schemas/User"
 *             )
 *         )
 *     )
 * )
 */

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',
            'password_confirmation' => 'required|string',
        ]);

        $user->update($validatedData);

        return response()->json(['user' => $user]);
    }

    
/**
 * @OA\Delete(
 *     path="/api/users/{id}",
 *     tags={"Users"},
 *     summary="Delete a user",
 *     description="Delete a specific user by ID",
 *     operationId="deleteUser",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the user to delete",
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="User deleted successfully"
 *             )
 *         )
 *     )
 * )
 */

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $user->delete();

        return response()->json(null, 204);
    }

  /**
 * @OA\Post(
 *     path="/api/register",
 *     tags={"register"},
 *     summary="Register a new user",
 *     description="Register a new user with name, email, password, and password confirmation.",
 *     operationId="registerUser",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User registration details",
 *         @OA\JsonContent(
 *             required={"name", "email", "password", "password_confirmation"},
 *             @OA\Property(property="name", type="string", example="John Doe", description="User's name"),
 *             @OA\Property(property="email", type="string", format="email", example="john@example.com", description="User's email"),
 *             @OA\Property(property="password", type="string", format="password", example="password", description="User's password"),
 *             @OA\Property(property="password_confirmation", type="string", format="password", example="password", description="Password confirmation")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User successfully registered",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User registered successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object", example={
 *                 "name": {"The name field is required."},
 *                 "email": {"The email field is required.", "The email must be a valid email address."},
 *                 "password": {"The password field is required.", "The password must be at least 8 characters."},
 *                 "password_confirmation": {"The password confirmation does not match."}
 *             })
 *         )
 *     )
 * )
 */
public function register(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users,email',
        'password' => 'required|string|min:8',
    ]);

    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    $token = $user->createToken('apptoken'.$user->id, ['*'])->plainTextToken;

    return response()->json([
        'message' => 'User registered successfully',
        'status' => 'success',
        'data' => [
            "user" => $user,
            "token" => $token
        ]
    ], 201);
}

/**
 * @OA\Post(
 *     path="/api/login",
 *     tags={"login"},
 *     summary="login a user",
 *     description="login a user with email, password.",
 *     operationId="loginUser",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User login details",
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="john@example.com", description="User's email"),
 *             @OA\Property(property="password", type="string", format="password", example="password", description="User's password"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User successfully login",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User login successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object", example={
 *                 "email": {"The email field is required.", "The email must be a valid email address."},
 *                 "password": {"The password field is required.", "The password must be at least 8 characters."},
 *             })
 *         )
 *     )
 * )
 */


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('apptoken' . $user->id, ['*'])->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'status' => 'success',
                'data' => [
                "user" => $user,
                "token" => $token
                ]
            ]);
        } else {
            return response()->json(['message' => 'Unauthorized', 'status' => 'error'], 401);
        }
    }

   /**
 * @OA\Get(
 *     path="/api/auth",
 *     tags={"auth"},
 *     summary="Authenticate User",
 *     description="Authenticate a user with email and password",
 *     operationId="authenticateUser",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User credentials",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     example="user@example.com",
 *                     description="User's email address"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string",
 *                     format="password",
 *                     example="password123",
 *                     description="User's password"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful authentication",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="access_token",
 *                 type="string",
 *                 description="JWT access token"
 *             ),
 *             @OA\Property(
 *                 property="token_type",
 *                 type="string",
 *                 description="Type of token (Bearer)"
 *             ),
 *             @OA\Property(
 *                 property="expires_in",
 *                 type="integer",
 *                 description="Token expiration time in seconds"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 description="Unauthorized access error message"
 *             )
 *         )
 *     )
 * )
 */

}
