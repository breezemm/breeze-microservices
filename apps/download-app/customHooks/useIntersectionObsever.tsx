import { useEffect, useState, useRef, RefObject } from "react";

export default function useIntersecionObserver(ref: RefObject<HTMLElement>) {
    const observerRef = useRef<IntersectionObserver | null>(null);
    const [isIntersecting, setIsIntersecting] = useState(false);

    useEffect(() => {
        if (!ref.current) {
            throw new Error("ref.current is null");
        }

        const observer = new IntersectionObserver(
            ([entry]) => {
                setIsIntersecting(entry.isIntersecting);
            },
            {
                rootMargin: "0px 0px 100px 0px",
            }
        );

        observer.observe(ref.current);

        observerRef.current = observer;

        return () => {
            if (observerRef.current) {
                observerRef.current.disconnect();
            }
        };
    }, [ref]);
    
    return isIntersecting;
}