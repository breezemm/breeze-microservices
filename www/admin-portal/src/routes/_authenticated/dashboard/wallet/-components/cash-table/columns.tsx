import { ColumnDef } from "@tanstack/react-table"



export type Cash_History_Data = {
    id: number
    date: string
    username: string
    cash_flow: "Cash-in" | "Cash-out" 
    amount: number
}

export const columns: ColumnDef<Cash_History_Data>[] = [
    {
      accessorKey: "date",
      header: "Date",
    },
    {
      accessorKey: "username",
      header: "Username",
    },
    {
        accessorKey: "cash_flow",
        header: "Cash Flow",
      },
    {
      accessorKey: "amount",
      header: "Amount",
    }
    
  ]