declare global {
    interface Window {
        // Definisikan 'snap' di dalam object window
        snap: {
            // Definisikan method 'pay' beserta parameter dan callback-nya
            pay: (
                snapToken: string,
                options?: {
                    onSuccess?: (result: any) => void;
                    onPending?: (result: any) => void;
                    onError?: (result: any) => void;
                    onClose?: () => void;
                }
            ) => void;
        };
    }
}

export {};
