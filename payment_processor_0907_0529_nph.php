<?php
// 代码生成时间: 2025-09-07 05:29:21
use Illuminate\Support\Facades\Log;
use App\Exceptions\PaymentFailedException;
use App\PaymentGateway;
use App\Services\PaymentService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @var PaymentService
     */
    private $paymentService;

    /**
     * PaymentController constructor.
     *
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Process the payment and return the result.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function processPayment(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|in:USD,EUR,GBP',
            'payment_method' => 'required|in:credit_card,paypal',
        ]);

        try {
            // Process the payment
            $result = $this->paymentService->process($validatedData);

            if ($result['status'] === 'success') {
                return response()->json(['message' => 'Payment successful'], 200);
            } else {
                throw new PaymentFailedException('Payment failed: ' . $result['message']);
            }
        } catch (PaymentFailedException $e) {
            // Log the error and return an error response
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (Exception $e) {
            // General error handling
            Log::error($e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }
}

/**
 * PaymentService class responsible for handling payment logic.
 */
class PaymentService
{
    /**
     * Process the payment using the selected payment method.
     *
     * @param array $data
     * @return array
     */
    public function process(array $data)
    {
        // Instantiate the payment gateway
        $paymentGateway = new PaymentGateway($data['payment_method']);

        // Process the payment
        if ($paymentGateway->process($data)) {
            return ['status' => 'success', 'message' => 'Payment processed successfully'];
        } else {
            return ['status' => 'failed', 'message' => 'Payment processing failed'];
        }
    }
}

/**
 * PaymentFailedException custom exception for payment failures.
 */
class PaymentFailedException extends \Exception
{
    // Custom exception for payment failures
}
