using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Microsoft.Office.Interop.Excel;
using System.Reflection;

namespace CAP6777_HW4
{
    class Program
    {
        static void Main(string[] args)
        {
            int matrixSize = 1002;
            int vectorArraySize = 100;
            double vectorInitalValue = 1;

            try
            {
                Console.Out.WriteLine("Specify Matrix Size");
                Console.Out.Write(">> ");
                matrixSize = int.Parse(Console.In.ReadLine());
                Console.Out.WriteLine("Specify Initial PageRank");
                Console.Out.Write(">> ");
                vectorInitalValue = double.Parse(Console.In.ReadLine());
                Console.Out.WriteLine("Specify Amount of Iterations");
                Console.Out.Write(">> ");
                vectorArraySize = int.Parse(Console.In.ReadLine());
                Matrix m = new Matrix(matrixSize);
                new Multiplication(m.matrix, vectorInitalValue, vectorArraySize);
            }
            catch
            {
                Console.Out.WriteLine("There was problem with your input");
            }
        }
    }

    class Matrix
    {
        public List<List<double>> matrix { set; get; }

        public Matrix(int msize)
        {
            matrix = new List<List<double>>();
            int size = msize;
            RowA(size);
            RowB(size);
            RowThousand(size);
        }

        private void RowA(int size)
        {
            List<double> row = new List<double>();
            for (int i = 0; i < size; i++)
            {
                if (i == 0 || i == 1) row.Add(0.0);
                else row.Add(1.0);
            }
            matrix.Add(row);
        }

        private void RowB(int size)
        {
            List<double> row = new List<double>();
            for (int i = 0; i < size; i++)
            {
                if (i == 0) row.Add(1.0);
                else row.Add(0.0);
            }
            matrix.Add(row);
        }

        private void RowThousand(int size)
        {
            for (int k = 0; k < size - 2; k++)
            {
                List<double> row = new List<double>();
                for (int i = 0; i < size; i++)
                {
                    int tempInt = size - 2;
                    double tempDbl = (double)((double)1 / (double)tempInt);
                    if (i == 1) row.Add(tempDbl);
                    else row.Add(0.0);
                }
                matrix.Add(row);
            }
        }
    }

    class Multiplication
    {
        public List<List<double>> vectors { get; set; }
        public Multiplication(List<List<double>> matrix, double value, int size)
        {

            vectors = new List<List<double>>();
            vectors.Add(FirstVector(matrix, value));
            for (int i = 0; i <= size; i++)
            {
                Console.Out.WriteLine("Vector " + (i + 1).ToString());
                vectors.Add(Compute(matrix, vectors[i]));

            }
            WriteToFile(matrix, vectors);
        }

        public List<double> FirstVector(List<List<double>> matrix, double value)
        {
            List<double> vector = new List<double>();
            for (int i = 0; i < matrix.Count; i++)
            {
                vector.Add(value);
            }
            return vector;
        }

        public List<double> Compute(List<List<double>> matrix, List<double> input)
        {
            List<double> vector = new List<double>();
            for (int i = 0; i < matrix.Count; i++)
            {
                double temporary = 0.0;
                for (int j = 0; j < matrix.Count; j++)
                {
                    temporary += (matrix[i][j] * input[j]);
                }
                vector.Add(temporary);
            }
            return vector;
        }
        public void WriteToFile(List<List<double>> matrix, List<List<double>> input)
        {
            Console.Out.WriteLine("-------------");
            Microsoft.Office.Interop.Excel.Application ex = new Microsoft.Office.Interop.Excel.Application();
            Microsoft.Office.Interop.Excel.Workbook wb = ex.Workbooks.Add();
            Microsoft.Office.Interop.Excel.Worksheet ws = wb.ActiveSheet;
            ex.Visible = true;

            for (int i = 0; i < matrix[0].Count; i++)
            {
                for (int j = 0; j < matrix.Count; j++)
                {
                    ws.Cells[i + 1, j + 1].Value = matrix[i][j];
                }
                Console.Out.WriteLine("Matrix Row " + (i + 1).ToString());
            }
            Console.Out.WriteLine("-------------");
            for (int i = 0; i < input[0].Count; i++)
            {
                for (int j = 0; j < input.Count; j++)
                {
                    ws.Cells[i + 1, j + 2 + matrix.Count].Value = input[j][i];
                }
                Console.Out.WriteLine("Vector Row " + (i + 1).ToString());
            }
        }
    }
}
